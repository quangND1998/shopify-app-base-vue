<?php

namespace App\Actions;

use App\Jobs\Shoffi\CreateMerchantShoffiJob;
use Illuminate\Http\Request;
use QuangND\Shopify\Actions\AfterAuthorize;
use QuangND\Shopify\Actions\AuthenticateShop as BaseAuthenticateShop;
use App\Actions\AuthorizeShop;
use QuangND\Shopify\Actions\BeforeAuthorize;
use QuangND\Shopify\Actions\DispatchScripts;
use QuangND\Shopify\Actions\DispatchWebhooks;
use QuangND\Shopify\Helpers\Helper;
use QuangND\Shopify\Repositories\AppSettings\AppSettingRepository;
use PHPShopify\AuthHelper;
use PHPShopify\Exception\SdkException;
use PHPShopify\ShopifySDK;

class AuthenticateShop extends BaseAuthenticateShop
{
    public function __construct(
        AuthorizeShop $authorizeShopAction,
        AppSettingRepository $appSettingRepo,
        DispatchWebhooks $dispatchWebhooksAction,
        DispatchScripts $dispatchScriptsAction,
        AfterAuthorize $afterAuthorizeAction,
        BeforeAuthorize $beforeAuthorizeAction
    )
    {
        parent::__construct($authorizeShopAction, $appSettingRepo, $dispatchWebhooksAction, $dispatchScriptsAction, $afterAuthorizeAction, $beforeAuthorizeAction);
    }

    /**
     * Execution.
     *
     * @param Request $request The request object.
     *
     * @return array
     * @throws SdkException
     */
    public function __invoke(Request $request): array
    {
        // Setup
        $shopDomain = $request->get('shop');
        $code = $request->get('code');
        $appId = Helper::getShopifyConfig('app_id');
        $appSetting = $this->appSettingRepo->getById($appId);
        $result = [];

        call_user_func($this->beforeAuthorizeAction, $shopDomain, false);

        // Check verify request
        $config = array(
            'ShopUrl' => $shopDomain,
            'ApiKey' => $appSetting->api_key,
            'SharedSecret' => $appSetting->shared_secret,
        );
        ShopifySDK::config($config);
        $verify = AuthHelper::verifyShopifyRequest();
        if (!$verify) {
            return [$result, null];
        }

        // Run the check
        $result = call_user_func($this->authorizeShopAction, $shopDomain, $code);
        if (!$result->completed) {
            // No code, redirect to auth URL
            return [$result, false];
        }

        // Fire the post-processing jobs
        call_user_func($this->dispatchWebhooksAction, $result->userSetting, false);
        // \Omega\Shopify\Jobs\ScriptTagShouldBeEnabled::dispatch($result->userSetting);
        call_user_func($this->afterAuthorizeAction, $result->userSetting, false);
        // CreateMerchantShoffiJob::dispatch($shopDomain, $request->server('HTTP_X_FORWARDED_FOR'));

        return [$result, true];
    }
}
