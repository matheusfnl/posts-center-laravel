<script setup lang="ts">
  import { ref, getCurrentInstance } from 'vue';
  import { useRouter } from 'vue-router';

  import Spinner from '@/shared/SpinnerFeedback.vue';

  import { login } from '@/api/login';

  const email = ref('');
  const password = ref('');
  const request_pending = ref(false);

  const { proxy } = getCurrentInstance() || {};
  const router = useRouter()

  const handleSignUp = () => {
    proxy?.$modal?.close();
    router.push('/register');
  };

  const handleLogin = async () => {
    request_pending.value = true;

    await login({
      email: email.value,
      password: password.value,
    });

    request_pending.value = false;
    proxy?.$modal?.close();
    proxy?.$auth?.login();
  };
</script>

<template>
  <div class="login-modal-container">
    <div class="login-modal-header">
      Sign in
    </div>

    <div class="input-container">
      <label for="email">Email</label>
      <input name="email" type="text" v-model="email" />
    </div>

    <div class="input-container">
      <label for="password">Password</label>
      <input name="password" type="password" v-model="password" />
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