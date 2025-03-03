<?php

namespace App\Actions;

use QuangND\Shopify\Repositories\UserSettings\UserSetting;
use PHPShopify\ShopifySDK;

/**
 * Create webhooks for this app on the shop.
 */
class UpsertWebhooks
{
    /**
     * Execution.
     * TODO: Rethrow an API exception.
     *
     * @param UserSetting $userSetting The user setting.
     * @param array       $configWebhooks The webhooks to add.
     *
     * @return array
     */
    public function __invoke(UserSetting $userSetting, array $configWebhooks, $isUpdate = false, $isDelete = true): array
    {
        // Define the function to check if a webhook exists
        $exists = function (array $webhook, $webhooks) {
            foreach ($webhooks as $shopWebhook) {
                if ($shopWebhook['address'] === $webhook['address']) {
                    // Found the webhook in our list
                    return $shopWebhook;
                }
            }
            return false;
        };

        $config = array(
            'ShopUrl' => $userSetting->getShopDomain(),
            'AccessToken' => $userSetting->getAccessToken(),
        );
        $shopify = ShopifySDK::config($config);

        // Get the webhooks existing in for the shop
        $webhooks = $shopify->Webhook()->get();
        $created = [];
        $updated = [];
        $deleted = [];
        $used = [];

        foreach ($configWebhooks as $webhook) {
            try {
                // Check if the required webhook exists on the shop
                $existWebhook = $exists($webhook, $webhooks);
                if ($existWebhook) {
                    // Update the webhook if it already exists
                    if ($isUpdate) {
                        $shopify->Webhook($existWebhook['id'])->put($webhook);
                        $updated[] = $webhook;
                    }
                } else {
                    // It does not exist, create the webhook
                    if ($webhook['topic'] != 'products/update') {
                        $shopify->Webhook()->post($webhook);
                        $created[] = $webhook;
                    }
                }
            } catch (\Throwable $th) {
                // Handle exceptions
            }

            $used[] = $webhook['address'];
        }

        // Delete unused webhooks
        foreach ($webhooks as $webhook) {
            if (!in_array($webhook['address'], $used) && $isDelete) {
                try {
                    // Webhook should be deleted
                    if ($webhook['topic'] != 'products/update') {
                        $shopify->Webhook($webhook['id'])->delete();
                        $deleted[] = $webhook;
                    }
                } catch (\Throwable $th) {
                    // Handle exceptions
                }
            }
        }

        \Log::info("UpsertWebhooks: " . $userSetting->getShopDomain() . " done!, result:" . json_encode([
            'created' => $created,
            'updated' => $updated,
            'deleted' => $deleted,
        ]));

        return [
            'created' => $created,
            'updated' => $updated,
            'deleted' => $deleted,
        ];
    }
}
