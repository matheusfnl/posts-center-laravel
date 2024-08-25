<script setup lang="ts">
  import { ref, getCurrentInstance } from 'vue';
  import { useRouter } from 'vue-router';

  const username = ref('');
  const password = ref('');

  const { proxy } = getCurrentInstance() || {};
  const router = useRouter()

  const handleSignUp = () => {
    proxy?.$modal?.close();
    router.push('/register');
  };
</script>

<template>
  <div class="login-modal-container">
    <div class="login-modal-header">
      Sign in
    </div>

    <div class="input-container">
      <label for="username">Username</label>
      <input name="username" type="text" v-model="username" />
    </div>

    <div class="input-container">
      <label for="password">Password</label>
      <input name="password" type="password" v-model="password" />
    </div>

    <div class="actions-container">
      <button class="secondary-button">
        Sign in
      </button>
    </div>

    <div class="extra-options">
      <span>
        Don't have an account?

        <button @click="handleSignUp">Create one.</button>
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

  .extra-options button {
    cursor: pointer;
    color: var(--primary-500);
    text-decoration: none;
    background-color: transparent;
    margin: 0;
    padding: 0;
    border: none;
  }

  .extra-options button:focus {
    border: none;
    outline: none;
  }

  .extra-options button:hover {
    color: var(--primary-600);
    text-decoration: underline;
  }
</style>