import axios from 'axios';
import createApp from "@shopify/app-bridge";
import { getSessionToken } from "@shopify/app-bridge/utilities";
import { getParameterQuery } from '@/common/utils/helper';
const SHOP = window.OT_SHOP || '';
const SHOP_NAME = SHOP.replace('.myshopify.com', '');
const HOST = window.OT_HOST || window.btoa('admin.shopify.com/store/' + SHOP_NAME);
const appBridgeConfig = createApp({
  apiKey: import.meta.env.VITE_SHOPIFY_API_KEY,
  host: HOST,
  // host: Buffer.from(process.env.MIX_APP_URL).toString('base64'),
  forceRedirect: false,
});
const instance = () => {
  const params = getParameterQuery();
  const instance = axios.create({

    params: params,
  });
  console.log(params);
  instance.interceptors.request.use(async function (config) {
    if ('forceRedirect' in params && params['forceRedirect'] == '0') {
      return config;
    }
    return getSessionToken(appBridgeConfig) // requires a Shopify App Bridge instance
      .then((token) => {

        // Append your request headers with an authenticated token
        config.headers['Authorization'] = `Bearer ${token}`;
        config.headers['Content-Security-Policy'] =
          `frame-ancestors https://${SHOP} https://admin.shopify.com`;
        return config;
      })
      .catch((e) => { });
  });
  return instance;
};
export default instance;
