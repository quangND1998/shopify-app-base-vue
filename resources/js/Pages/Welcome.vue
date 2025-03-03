<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import ShopifyLayout from "@/Layouts/ShopifyLayout.vue";
import { useProductStore } from "@/common/stores/useProductStore";
import { IQueryProduct, IResponseProduct, useProductQuery } from '@/repositories/products/productHooks';
import { computed, reactive } from 'vue';
defineProps<{
  canLogin?: boolean;
  canRegister?: boolean;
  laravelVersion: string;
  phpVersion: string;
}>();

const queryProduct = reactive<IQueryProduct>({
  q: "",
  page: 1,
  limit: 10,
});
const save  = () => {
    console.log("aaaaaaaaaaaa")
};
const { data: dataProducts, isSuccess: settingSuccess } =
  useProductQuery(queryProduct);

const productStore = useProductStore();

const products = computed<IResponseProduct>(() => productStore.products);
</script>

<template>
  <ShopifyLayout>
    <Page :backAction="{ content: 'Settings', url: '#' }" title="General">
      <template #primaryAction>
        <Button variant="primary">Save</Button>
      </template>

      <LegacyCard title="Credit card" sectioned>
        <Text as="p">Credit card information</Text>
      </LegacyCard>
    </Page>
  </ShopifyLayout>
</template>

<style>
.bg-dots-darker {
  background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}

@media (prefers-color-scheme: dark) {
  .dark\:bg-dots-lighter {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
  }
}
</style>
