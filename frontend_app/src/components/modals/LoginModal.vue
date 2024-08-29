<script setup lang="ts">
  import { ref, getCurrentInstance } from 'vue';
  import { useRouter } from 'vue-router';

  import Spinner from '@/shared/SpinnerFeedback.vue';

  import { login } from '@/api/login';

  import { useAuthStore } from '@/stores/auth';

  import type ApiError from '@/interfaces/api-error';
  import type ExtendedError from '@/interfaces/extended-error';

  const authStore = useAuthStore();
  const email = ref('');
  const password = ref('');
  const request_pending = ref(false);
  const api_errors = ref<ApiError>({});

  const { proxy } = getCurrentInstance() || {};
  const router = useRouter()

  const handleSignUp = () => {
    proxy?.$modal?.close();
    router.push('/register');
  };

  const handleLogin = async () => {
    request_pending.value = true;

    const user = await login({
      email: email.value,
      password: password.value,
    });

    request_pending.value = false;

    if (user instanceof Error) {
      const { response: { data: { errors = {} as ApiError } = {} } = {} } = user as ExtendedError;

      return api_errors.value = errors;
    }

    authStore.setUser(user);
    proxy?.$modal?.close();
  };

  const getHasError = (field: string) => {
    if (api_errors.value?.[field]?.length) {
      return api_errors.value[field][0];
    }

    return '';
  }
</script>

<template>
  <div class="login-modal-container">
    <div class="login-modal-header">
      Sign in
    </div>

    <div class="input-container">
      <label for="email">Email</label>
      <input name="email" type="text" v-model="email" />
      <span class="error-feedback" v-if="getHasError('email')">{{ getHasError('email') }}</span>
    </div>

    <div class="input-container">
      <label for="password">Password</label>
      <input name="password" type="password" v-model="password" />
      <span class="error-feedback" v-if="getHasError('password')">{{ getHasError('password') }}</span>
    </div>

    <div class="actions-container">
      <button class="secondary-button" @click="handleLogin">
        <Spinner :size="16" class="spinner-icon" v-if="request_pending" />
        <template v-else>Sign in</template>
      </button>
    </div>

    <div class="extra-options">
      <span>
        Don't have an account?

        <button class="primary-link-button" @click="handleSignUp">Create one.</button>
      </span>
    </div>
  </div>
</template>

<style scoped>
  .login-modal-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    width: 340px;
    padding: 8px;
  }

  .login-modal-header {
    display: flex;
    justify-content: center;
    font-size: 18px;
  }

  .input-container {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .input-container .error-feedback {
    color: var(--error-500);
    font-size: 12px;
  }

  .actions-container {
    display: flex;
    justify-content: flex-end;
  }

  .actions-container button {
    width: 100%;
    font-weight: 500;
  }

  .extra-options {
    display: flex;
    justify-content: center;
    font-size: 12px;
    color: var(--base-800);
  }

  .spinner-icon { fill: var(--base-50); }
</style>