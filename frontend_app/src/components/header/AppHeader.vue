<script setup lang="ts">
  import ThemeSelector from '@/components/header/ThemeSelector.vue';
  import AuthHandler from '@/components/header/AuthHandler.vue';
  import HomeHandler from '@/components/header/HomeHandler.vue';
</script>

<template>
  <div class="header-container">
    <div class="header-actions">
      <HomeHandler />
      <ThemeSelector />
      <AuthHandler />
    </div>
  </div>
</template>

<style scoped>
  .header-container {
    max-width: 1440px;
    margin: auto;
    display: flex;
    justify-content: flex-end;
  }

  .header-actions {
    position: fixed;
    padding: 8px;
    display: flex;
    gap: 10px;
  }
</style>