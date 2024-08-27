<script setup lang="ts">
  import { onMounted } from 'vue';

  import Modal from '@/components/plugins/UseModal.vue';
  import Appheader from '@/components/header/AppHeader.vue';

  import { getUser } from '@/api/getUser';

  import { useAuthStore } from '@/stores/auth';

  const authStore = useAuthStore();

  onMounted(async () => {
    const token = localStorage.getItem('@auth');

    if (token) {
      const user = await getUser();

      if (user?.id) {
        authStore.setUser(user);
      }
    }
  });
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
