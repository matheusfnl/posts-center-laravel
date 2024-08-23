<script setup lang="ts">
  import Modal from '@/components/plugins/UseModal.vue';
  import ThemeSelector from '@/components/theme/ThemeSelector.vue';
</script>

<template>
  <div>
    <Modal />
    <ThemeSelector />
    <main class="main-app">
      <RouterView />
    </main>
  </div>
</template>

<style scoped>
  .main-app {
    max-width: 1440px;
    margin: auto;
  }
</style>
