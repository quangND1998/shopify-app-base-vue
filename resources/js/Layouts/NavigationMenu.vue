<script setup lang="ts">
import { ref, onMounted, watch, defineProps } from "vue";
import createApp from "@shopify/app-bridge";
import { AppLink, NavigationMenu } from "@shopify/app-bridge/actions";
import { AppProvider, Frame, Navigation } from '@ownego/polaris-vue';
interface MenuItem {
  label: string;
  destination: string;
  options?: object;
}

const props = defineProps<{
  items: MenuItem[];
}>();

const app = ref<any>(null);
const navigationMenu = ref<ReturnType<typeof NavigationMenu.create> | null>(null);

// Lấy thông tin từ URL
const urlParams = new URLSearchParams(window.location.search);
const SHOP = window.OT_SHOP || "";
const SHOP_NAME = SHOP.replace(".myshopify.com", "");
const HOST =
  window.OT_HOST ||
  urlParams.get("host") ||
  window.btoa(`admin.shopify.com/store/${SHOP_NAME}`);

onMounted(() => {
  if (!HOST) {
    console.error('Shopify App Bridge: "host" parameter is missing.');
    return;
  }

  // Khởi tạo Shopify App Bridge
  app.value = createApp({
    apiKey: import.meta.env.VITE_SHOPIFY_API_KEY,
    host: HOST,
    forceRedirect: false,
  });

  updateNavigationMenu();
});

// Hàm cập nhật Navigation Menu
const updateNavigationMenu = () => {
  if (!app.value || !props.items?.length) return;
  const menuItems = props.items.map((item, index) =>
    AppLink.create(app.value, {
      label: item.label,
      destination: item.destination,
    })
  );

  if (!navigationMenu.value) {
    navigationMenu.value = NavigationMenu.create(app.value, {
      items: menuItems,
    });
  } else {
    navigationMenu.value.set({ items: menuItems });
  }
};

watch(() => props.items, updateNavigationMenu, { deep: true });
</script>

<template>
  <div></div>
</template>
