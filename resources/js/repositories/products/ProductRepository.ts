import ApiClient from "../ApiClient";
import { BaseResponse } from "../BaseRepository";
import { IQueryProduct, IResponseProduct } from "./productHooks";

const path = '/api/v1/products';
const fetchProducts: (query: IQueryProduct) => Promise<IResponseProduct & BaseResponse> = (query) => {
    return ApiClient.get(path, { params: query }).then((response) => {
      return response.data;
    });
};


export default {
    fetchProducts
}