import { Register, useMutation, useQuery, useQueryClient } from '@tanstack/vue-query';
import ProductRepository from './ProductRepository';
import { useProductStore } from '@/common/stores/useProductStore';
export interface IQueryProduct {
    q?: string;
    page?: string | number;
    limit?: string | number;
}
export interface IProduct {
    id: number;
    name: string;
    price: string;
    description: string;
}
export interface IResponseProduct  {
    data: IProduct[],
    current_page: number,
    first_page_url: string,
    from: number,
    last_page: number,
    last_page_url: string,
    links: {
        url: string | null,
        label: string,
        active: boolean
    }[],
    next_page_url: string | null,
    path: string,
    per_page: number,
    prev_page_url: string | null,
    to: number,
    total: number
}
  
export const useProductQuery = (query: IQueryProduct) => {
    const store = useProductStore()
    return useQuery({
        queryKey: ['products'],
        queryFn: () => {
            return ProductRepository.fetchProducts(query);
        },
        select: (response: IResponseProduct) => {
            store.setProducts(response);
        },
        staleTime: 3000
    });
};

