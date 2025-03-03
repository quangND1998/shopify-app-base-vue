<?php

namespace App\Http\Middleware;

use App\Repositories\UserSettings\UserSettingRepository;
use Closure;
use Darkness\Response\ResponseHandler;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use QuangND\Shopify\Helpers\Helper;
use QuangND\Shopify\Http\Middleware\AuthApi as Authenticate;
use QuangND\Shopify\Repositories\AppSettings\AppSettingRepository;

class AuthApi extends Authenticate
{
    use ResponseHandler;
    /**
     * The header name.
     *
     * @var string
     */
    protected $header = 'authorization';

    /**
     * The header prefix.
     *
     * @var string
     */
    protected $prefix = 'bearer';

    public function __construct(
        AppSettingRepository $appSettingRepo,
        UserSettingRepository $userSettingRepository
    ) {
        parent::__construct($appSettingRepo);
        $this->userSettingRepo = $userSettingRepository;
    }

    public function handle(Request $request, Closure $next)
    {
        try {
 
            $appSetting = $this->appSettingRepo->getById(Helper::getShopifyConfig('app_id'));
            $token = $this->parse($request);
          
           
            if (env('SHOP_FOR_LOCAL')) {
                $shop = env('SHOP_FOR_LOCAL');
               
            }
            else if($request->has('token_id')) {
             
                $token = $request->get('token_id');
                $jwtPayload = self::decodeSessionToken($appSetting->getApiSecret(), $token);
                $shop = preg_replace('/^https:\/\//', '', $jwtPayload['dest']);
            }
            else {
             
                if (!$token) {
                    if ($request->cookies->has('token')) {
                        $token = $request->cookies->get('token');
                    } else {
                        throw new \Exception('Missing Authorization key in headers array');
                    }
                }
          
                $jwtPayload = self::decodeSessionToken($appSetting->getApiSecret(), $token);
                $shop = preg_replace('/^https:\/\//', '', $jwtPayload['dest']);
            }
           
            $userSetting = $this->userSettingRepo->getCurrentShop($appSetting->id, $shop);
            if (!$userSetting) {
                return $this->errorResponse([
                    'error' => 'Shop does not installed yet.'
                ]);
            }
            Auth::login($userSetting);
            return $next($request);
        } catch (\Exception $exception) {
            return $this->errorResponse([
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Decodes the given session token and extracts the session information from it
     *
     * @param string $secretKey
     * @param string $jwt A compact JSON web token in the form of xxxx.yyyy.zzzz
     *
     * @return array The decoded payload which contains claims about the entity
     */
    public static function decodeSessionToken(string $secretKey, string $jwt): array
    {
        JWT::$leeway = 10;
        $payload = JWT::decode($jwt, new Key($secretKey, 'HS256'));
        return (array) $payload;
    }

    /**
     * Try to parse the token from the request header.
     *
     * @param Request $request
     * @return null|string
     */
    public function parse(Request $request): ?string
    {
        $header = $request->headers->get($this->header);

        if ($header !== null) {
            $position = strripos($header, $this->prefix);

            if ($position !== false) {
                $header = substr($header, $position + strlen($this->prefix));

                return trim(
                    strpos($header, ',') !== false ? strstr($header, ',', true) : $header
                );
            }
        }

        return null;
    }
}
