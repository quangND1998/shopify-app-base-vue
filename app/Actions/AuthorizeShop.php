<?php

namespace App\Actions;

use App\Jobs\CustomerIO\SyncDataToCustomerIOJob;
use App\Jobs\Mixpanel\SendMixpanelJob;
use App\Jobs\SyncMetafieldsToShopifyJob;
use App\Models\Event;
use App\Repositories\FeedSettings\FeedSettingRepository;
use App\Repositories\Plans\Plan;
use App\Repositories\Plans\PlanRepository;
use App\Repositories\Settings\SettingRepository;
use Carbon\Carbon;
use QuangND\Shopify\Actions\AuthorizeShop as BaseAuthorizeShop;
use QuangND\Shopify\Helpers\Helper;
use QuangND\Shopify\Repositories\AppSettings\AppSettingRepository;
use App\Repositories\ShopInstalleds\ShopInstalledRepository;
use App\Repositories\UserSettings\UserSettingRepository;
use App\Services\Plans\PlanService;
use PHPShopify\AuthHelper;
use PHPShopify\ShopifySDK;

class AuthorizeShop extends BaseAuthorizeShop
{
    /**
     * The setting handler
     *
     * @var SettingRepository
     */
    protected $settingRepo;
    protected $feedSettingRepo;
    protected $planService;

    public function __construct(
        AppSettingRepository $appSettingRepo,
        ShopInstalledRepository $shopInstalledRepo,
        UserSettingRepository $userSettingRepo,
        PlanRepository $planRepo
   
    ) {
        parent::__construct($appSettingRepo, $shopInstalledRepo, $userSettingRepo, $planRepo);


    }


    /**
     * Execution.
     * TODO: Rethrow an API exception.
     *
     * @param string $shopDomain The shop ID.
     * @param string|null $code The code from Shopify.
     *
     * @throws
     */
    public function __invoke(string $shopDomain, ?string $code)
    {
        $appSetting = $this->appSettingRepo->getById(Helper::getShopifyConfig('app_id'));

        // Return data
        $return = [
            'completed' => false,
            'url'       => null,
        ];

        $config = array(
            'ShopUrl' => $shopDomain,
            'ApiKey' => $appSetting->api_key,
            'SharedSecret' => $appSetting->shared_secret,
        );
        ShopifySDK::config($config);

        // If there's no code
        if (empty($code)) {
            $return['url'] = AuthHelper::createAuthRequest($appSetting->permissions, $appSetting->redirect_url, null, null, true);
            return (object) $return;
        }

        $accessToken = AuthHelper::getAccessToken();

        $config = array(
            'ShopUrl' => $shopDomain,
            'AccessToken' => $accessToken,
        );

        $shopify = ShopifySDK::config($config);

        // $this->activeWebPixelExtension($shopify);
        $shop = $shopify->Shop()->get();
        
        $now = date("Y-m-d H:i:s");
        $status = Helper::getShopifyConfig('billing_enabled') ? 'trial' : 'active';
      
        $shopInstalled = $this->shopInstalledRepo->getCurrentShopInstalled($appSetting->id, $shopDomain);
        $userSetting = $this->userSettingRepo->getCurrentShop($appSetting->id, $shopDomain);
        if ($shopInstalled) {
            if ($userSetting) {
                $userSetting->access_token = $accessToken;
                $userSetting->save();
            } else {
                $onetimeChargeInfo = [];
                $userSetting = $this->userSettingRepo->store(array_merge([
                    'access_token' => $accessToken,
                    'store_name' => $shopDomain,
                    'installed_date' => $shopInstalled->date_installed,
                    'app_id' => $appSetting->id,
                    'status' => $status,
                ], $onetimeChargeInfo));
            }

            try {
                $shopInstalled->fill([
                    'domain' => $shop['domain'],
                    'name_shop' => $shop['name'],
                    'email_shop' => $shop['email'],
                    'phone' => $shop['phone'],
                    'country' => $shop['country'],
                    'timezone' => $shop['timezone'],
                    'city' => $shop['city'],
                    'zipcode' => $shop['zip'],
                    'date_uninstalled' => null,
                    'last_installed_date' => $now
                ])->save();
            } catch (\Exception $e) {
            }
            // dispatch(new SyncDataToCustomerIOJob($userSetting, Event::EVENT_REINSTALL));
        } else {
            if ($userSetting) {
                $userSetting->access_token = $accessToken;
                $userSetting->save();
            } else {
                $userSetting = $this->userSettingRepo->store([
                    'access_token' => $accessToken,
                    'store_name' => $shopDomain,
                    'installed_date' => $now,
                    'app_id' => $appSetting->id,
                    'status' => $status,
                ]);
            }

            try {
                $shopInstalled = $this->shopInstalledRepo->store([
                    'shop' => $shopDomain,
                    'app_id' => $appSetting->id,
                    'date_installed' => $now,
                    'last_installed_date' => $now,
                    'domain' => $shop['domain'],
                    'name_shop' => $shop['name'],
                    'email_shop' => $shop['email'],
                    'phone' => $shop['phone'],
                    'country' => $shop['country'],
                    'timezone' => $shop['timezone'],
                    'city' => $shop['city'],
                    'zipcode' => $shop['zip'],
                    'store_created_at' => new Carbon($shop['created_at']),
                ]);
            } catch (\Exception $e) {
                $shopInstalled = $this->shopInstalledRepo->store([
                    'shop' => $shopDomain,
                    'app_id' => $appSetting->id,
                    'date_installed' => $now,
                ]);
            }
        }
        //$this->settingRepo->createOrUpdateForShop($shopDomain, ['shopify_plan' => $shop["plan_name"] ?? Plan::BASIC_PLAN]);

        // if ($userSetting) {
        //     $this->feedSettingRepo->upsertSettingFeed($shop, $userSetting['store_name']);
        // }

        // SyncMetafieldsToShopifyJob::dispatch($userSetting);
        // SendMixpanelJob::dispatch($shopDomain, $shop['id'], $shop['email'], $shop["plan_name"] ?? Plan::BASIC_PLAN, true);

        $return['completed'] = true;
        $return = (object) $return;
        $return->userSetting = $userSetting;
        $return->shopInstalled = $shopInstalled;

        return $return;
    }



    // public function activeWebPixelExtension(ShopifySDK $shopify)
    // {
    //     try {
    //         $query = '
    //         mutation webPixelCreate(
    //             $webPixel: WebPixelInput!
    //         ) {
    //             webPixelCreate(
    //                 webPixel: $webPixel
    //             ) {
    //                 userErrors {
    //                 code
    //                 field
    //                 message
    //               }
    //                 webPixel {
    //                 settings
    //                 id
    //               }
    //             }
    //         }
    //         ';
    //         $variables = [
    //             'webPixel'  => [
    //                 'settings' => [
    //                     'accountID' => 'facebook-web-pixel-live'
    //                 ]
    //             ],
    //         ];

    //         return $shopify->GraphQL->post($query, null, null, $variables);
    //     } catch (\Exception $exception) {
    //         return false;
    //     }
    // }
}
