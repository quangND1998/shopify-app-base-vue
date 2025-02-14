import { VueQueryPlugin, QueryClient, QueryCache, QueryKey } from '@tanstack/vue-query';
import ApiClient from '@/repositories/ApiClient';
export const defaultQueryFunction = ({
    queryKey,
}: {
    queryKey: QueryKey;
}): Promise<Record<number, any> & { meta: IMeta }> => {
    const path = queryKey.reduce(getPath, '');
    return ApiClient.get(path).then((res) => {
        return res?.data?.meta
            ? { ...res?.data?.data, meta: res?.data?.meta }
            : res?.data?.data;
    });
};
export interface IMeta {
    pagination: {
      total: number;
      count: number;
      per_page: number;
      current_page: number;
      total_pages: number;
    };
  }
interface ObjectToQueryStringParams {
    [key: string]: any;
}

const objectToQueryString = (obj: ObjectToQueryStringParams): string => {
    const queryString = Object.entries(obj)
        .map(
            ([key, value]) =>
                `${encodeURIComponent(key)}=${encodeURIComponent(value)}`,
        )
        .join('&');

    return `?${queryString}`;
};

const getPath = (path: string, curParam: any): string => {
    if (
        typeof curParam === 'object' &&
        !Array.isArray(curParam) &&
        curParam !== null
    ) {
        path += objectToQueryString(curParam);
    } else {
        path += `/${curParam}`;
    }

    return path;
};

const queryClient =  new QueryClient({
    defaultOptions: {
        queries: {
            queryFn: defaultQueryFunction,
            retry: 1,
            refetchOnWindowFocus: false,
            staleTime: Infinity,
        },
    
    },
    queryCache: new QueryCache({
  
    }),
});

export default queryClient