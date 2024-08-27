<script setup lang="ts">
  import { computed, ref, getCurrentInstance, onMounted } from 'vue';

  import LoginModal from '@/components/modals/LoginModal.vue';

  import LogoutIcon from '@/icons/LogoutIcon.vue';
  import UserIcon from '@/icons/UserIcon.vue';

  import { useAuthStore } from '@/stores/auth';

  import { logout } from '@/api/logout';

  import { bus } from '@/plugins/bus-emitter';

  const { proxy } = getCurrentInstance() || {};
  const authStore = useAuthStore();

  const logged = ref(!! authStore.user?.id);
  const getIcon = computed(() => {
    if (logged.value) {
      return LogoutIcon;
    }

    return UserIcon;
  })

  const handleClick = async () => {
    if (logged.value) {
      await logout();
      return logged.value = false;
    }

    proxy?.$modal?.open({ component: LoginModal })
  };

  onMounted(() => {
    bus.on('login', () => logged.value = true);
    bus.on('logout', () => logged.value = false);
  });
</script>

<template>
  <component class="auth-icon" :is="getIcon" @click="handleClick" />
</template>

<style scoped>
  .auth-icon { cursor: pointer; }
  .auth-icon * { stroke: var(--text-500); }
</style>