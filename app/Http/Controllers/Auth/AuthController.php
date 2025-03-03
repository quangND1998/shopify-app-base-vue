<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserSettings\UserSettingRepository;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use QuangND\Shopify\Exceptions\SignatureVerificationException;
use QuangND\Shopify\Helpers\Helper;
use QuangND\Shopify\Repositories\AppSettings\AppSettingRepository;
use PHPShopify\AuthHelper;
use Illuminate\Support\Facades\Redirect;
use App\Actions\AuthenticateShop;
class AuthController extends Controller
{

    protected $appSettingRepo;

    protected $userSettingRepo;

    /**
     * The authenticate shop handler
     *
     * @var AuthenticateShop
     */
    protected $authenticateShop;

    public function __construct(
        AppSettingRepository $appSettingRepo,
        AuthenticateShop $authenticateShop,
        UserSettingRepository $userSettingRepository
    ) {
        $this->appSettingRepo = $appSettingRepo;
        $this->authenticateShop = $authenticateShop;
        $this->userSettingRepo = $userSettingRepository;
    }

    /**
     * Authenticating a shop.
     * @throws SignatureVerificationException
     */
    public function authenticate(Request $request)
    {
        // Run the action, returns [result object, result status]
        [$result, $status] = call_user_func($this->authenticateShop, $request);

        if ($status === null) {
            // Show exception, something is wrong
            throw new SignatureVerificationException('Invalid HMAC verification');
        } elseif ($status === false) {
            // No code, redirect to auth URL
            return Redirect::to($result->url);
        } else {
            $shopDomain = $request->input('shop');
            $redirectAfterAuthenticateUrl = Helper::getShopifyConfig('redirect_after_authenticate_url');

            $appEmbed = Helper::getShopifyConfig('app_embed');
            if ($redirectAfterAuthenticateUrl && !$appEmbed) {
                return Redirect::to($redirectAfterAuthenticateUrl . '?' . $request->getQueryString() . "&firstVisit=1");
            }
            // No return_to, go home route
            $redirectUrl = Helper::getShopifyConfig('route_names.home');
            $appName = Helper::getShopifyConfig('app_name');
            if (Helper::getShopifyConfig('redirect_after_authenticate')) {
                $redirectUrl = "https://$shopDomain/admin/apps/$appName";
                if ($redirectAfterAuthenticateUrl) {
                    $redirectUrl = "https://$shopDomain/admin/apps/$appName/$redirectAfterAuthenticateUrl";
                }
                return Redirect::to($redirectUrl ."?firstVisit=1");
            }

            return Redirect::route($redirectUrl ."?firstVisit=1", $request->all());
        }
    }

    public function fakeLogin(Request $request)
    {

        $appSetting = $this->appSettingRepo->getById(Helper::getShopifyConfig('app_id'));
        $shopDomain = $request->input('shop');
        $userSetting = $this->userSettingRepo->getCurrentShop($appSetting->id, $shopDomain);
        $redirectUri = $request->input('redirect_uri');

        $sharedSecret = $appSetting->shared_secret;
        if (!$userSetting) {
            return view('shopify-app::error', ['message' => 'Not found shop']);
        }

        $request->request->remove('hmac');
        $request->request->remove('redirect_uri');
        $params = $request->all();
        $params['forceRedirect'] = 0;
        ksort($params);
        $token = self::encodeJwtPayload($appSetting->getApiSecret(), $shopDomain);
       
        $dataString = AuthHelper::buildQueryString($params);
        $hmac = hash_hmac('sha256', $dataString, $sharedSecret);
        $params['hmac'] = $hmac;

        if ($redirectUri) {
            $url = route('home') . "/$redirectUri?" . http_build_query($params);
            return redirect($url)->withCookie(cookie('token', $token, 43200));
        }

        return redirect()->route('home', $params)->withCookie(cookie('token', $token, 43200));
    }

    public function getToken(Request $request)
    {
        try {
            $shopDomain = $request->get('shop');
            if ($shopDomain) {
                $secretKey = env('SHOPIFY_API_SECRET');
                $token = self::encodeJwtPayload($secretKey, $shopDomain);

                return $this->successResponse([
                    'token' => $token,
                    'expiry' => strtotime('+24 hours')
                ]);
            }

            return $this->notFoundResponse();
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }
    
    private function encodeJwtPayload(string $secretKey, string $shopDomain): string
    {
        $payload = [
            "iss" => "https://" . $shopDomain . "/admin",
            "dest" => "https://" . $shopDomain,
            "aud" => "api-key-123",
            "sub" => "42",
            "exp" => strtotime('+1 month'),
            "nbf" => 1591764998,
            "iat" => 1591764998,
            "jti" => "f8912129-1af6-4cad-9ca3-76b0f7621087",
            "sid" => "aaea182f2732d44c23057c0fea584021a4485b2bd25d3eb7fd349313ad24c685"
        ];
        return JWT::encode($payload, $secretKey, 'HS256');
    }

}
