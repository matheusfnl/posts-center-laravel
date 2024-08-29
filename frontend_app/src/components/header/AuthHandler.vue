<script setup lang="ts">
  import { computed, ref, getCurrentInstance, onMounted } from 'vue';

  import LoginModal from '@/components/modals/LoginModal.vue';

  import LogoutIcon from '@/icons/LogoutIcon.vue';
  import UserIcon from '@/icons/UserIcon.vue';

  import { useAuthStore } from '@/stores/auth';

  import { logout } from '@/api/logout';

  const { proxy } = getCurrentInstance() || {};
  const authStore = useAuthStore();

  const getUser = computed(() => authStore.user);
  const getIcon = computed(() => {
    if (getUser.value?.id) {
      return LogoutIcon;
    }

    return UserIcon;
  })

  const handleClick = async () => {
    if (getUser.value?.id) {
      await logout();
      return authStore.setUser({});
    }

    proxy?.$modal?.open({ component: LoginModal })
  };

</script>

<template>
  <component class="auth-icon" :is="getIcon" @click="handleClick" />
</template>

<style scoped>
  .auth-icon { cursor: pointer; }
  .auth-icon * { stroke: var(--text-500); }
</style>