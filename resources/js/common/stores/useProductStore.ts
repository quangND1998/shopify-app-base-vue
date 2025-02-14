import { defineStore } from "pinia"
import { ref,computed } from "vue"
import { IProduct, IResponseProduct } from "@/repositories/products/productHooks"
export const useProductStore = defineStore('products', () => {
    const products = ref<IResponseProduct>({
        data: [],
        current_page: 1,
        first_page_url: '',
        from: 1,
        last_page: 1,
        last_page_url: '',
        links: [],
        next_page_url: '',
        path: '',
        per_page: 1,
        prev_page_url: '',
        to: 1,
        total: 1
    });

    const setProducts = (data: IResponseProduct) => {
        products.value = data;
    }
    return { products, setProducts }
    
})