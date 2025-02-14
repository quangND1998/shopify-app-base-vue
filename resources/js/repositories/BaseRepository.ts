import { ApiClient } from './ApiClient';

export interface BaseResponse {
  code: number;
  status: 'success' | 'error';
  error?: any;
}

