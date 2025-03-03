<script setup lang="ts">
import { ref } from "vue";
import { AppProvider } from "@ownego/polaris-vue";
import locales from "@ownego/polaris-vue/dist/locales/en.json";
import NavigationMenu from "@/Layouts/NavigationMenu.vue";

</script>

<template>
  <div>
    <AppProvider :i18n="locales">
      <NavigationMenu :items="[
        { label: 'Dashboard', destination: '/' },
        { label: 'Orders', destination: '/orders' },
        { label: 'Products', destination: '/products' }
      ]" />
      <main>
        <slot />
      </main>
    </AppProvider>
    <!-- Page Content -->
  </div>
</template>