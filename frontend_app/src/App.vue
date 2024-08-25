<script setup lang="ts">
  import Modal from '@/components/plugins/UseModal.vue';
  import Appheader from '@/components/header/AppHeader.vue';
</script>

<template>
  <div>
    <Modal />
    <Appheader />
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
