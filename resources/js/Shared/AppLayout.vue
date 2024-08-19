<template>
  <AppProvider>
    <div class="top-nav">
      <ILink href="/" class="logo">
        <!-- <img src="../../../public/images/logo.png" alt="Logo"> -->
        <h1>Task</h1>
      </ILink>
      <ul class="menu">
        <li class="menu-item">
          <ILink
            href="/"
            :class="{ active: $page.component === 'Welcome' }"
            class="menu-link"
            >Dashboard</ILink
          >
        </li>
        <li class="menu-item">
          <ILink
            href="/ebay-products"
            :class="{ active: $page.url.startsWith('/ebay-products') }"
            class="menu-link"
            >Ebay Products</ILink
          >
        </li>
        <li class="menu-item">
          <ILink
            href="/transfer-product"
            :class="{ active: $page.url.startsWith('/transfer-product') }"
            class="menu-link"
          >
            Transfer Product</ILink
          >
        </li>
      </ul>
    </div>
    <Page :fullWidth="true">
      <slot></slot>
    </Page>
  </AppProvider>
</template>

<script setup>
import { Link as ILink } from "@inertiajs/vue3";
</script>
