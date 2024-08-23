<script setup lang="ts">
  import Modal from '@/components/plugins/UseModal.vue';
  import ThemeSelector from '@/components/theme/ThemeSelector.vue';
</script>

<template>
  <div>
    <Modal />
    <ThemeSelector />
    <RouterView />
  </div>
</template>
