<script lang="ts" setup>
  import HomeIcon from '@/icons/HomeIcon.vue';

  import { useRouter } from 'vue-router';

  const router = useRouter();

  const handleHome = () => router.push('/');
</script>

<template>
  <HomeIcon :size="20" class="home-icon" @click="handleHome" />
</template>


<style scoped>
  .home-icon { cursor: pointer; }
  .home-icon * { stroke: var(--text-500); }
</style>