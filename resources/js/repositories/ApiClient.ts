import { AxiosInstance, AxiosRequestConfig, AxiosResponse } from 'axios';
import axios from './axiosInstances';

// axios.defaults.baseURL = process.env.MIX_APP_URL || '';
axios().defaults.headers.post['Content-Type'] = 'application/json';
axios().defaults.headers.post['Accept'] = 'application/json';
axios().defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
class ApiClient {
  private client: AxiosInstance;

  constructor() {
    this.client = axios();
  }

  private handleResponse(response: AxiosResponse) {
    return Promise.resolve(response.data); // response.data;
  }

  private handleError(error: any) {
    return Promise.reject(error.response ? error.response.data : error);
  }

  request(method: string, url: string, data: any = {}, config: AxiosRequestConfig = {}) {
    return this.client.request({ method, url, data, ...config })
      .then(this.handleResponse)
      .catch(this.handleError);
  }

  get(url: string, config: AxiosRequestConfig = {}) {
    return this.request('get', url, {}, config);
  }

  delete(url: string, config: AxiosRequestConfig = {}) {
    return this.request('delete', url, {}, config);
  }

  head(url: string, config: AxiosRequestConfig = {}) {
    return this.request('head', url, {}, config);
  }

  options(url: string, config: AxiosRequestConfig = {}) {
    return this.request('options', url, {}, config);
  }

  post(url: string, data = {}, config: AxiosRequestConfig = {}) {
    return this.request('post', url, data, config);
  }

  put(url: string, data = {}, config: AxiosRequestConfig = {}) {
    return this.request('put', url, data, config);
  }

  patch(url: string, data = {}, config: AxiosRequestConfig = {}) {
    return this.request('patch', url, data, config);
  }
}

export { ApiClient };
export default new ApiClient();


