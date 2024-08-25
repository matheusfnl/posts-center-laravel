<script setup lang="ts">
  import { ref, getCurrentInstance } from 'vue';
  import { useRouter } from 'vue-router';
  import LoginModal from '@/components/modals/LoginModal.vue';

  const username = ref('');
  const password = ref('');
  const confirmation_password = ref('');

  const { proxy } = getCurrentInstance() || {};
  const router = useRouter()

  const handleSignIn = () => {
    proxy?.$modal?.open({ component: LoginModal });
    router.push('/');
  };
</script>

<template>
  <div class="sign-up-container">
    <div class="posts-modal-container">
      <div class="posts-modal-header">
        Sign up
      </div>

      <div class="input-container">
        <label for="username">Username</label>
        <input name="username" type="text" v-model="username" />
      </div>

      <div class="input-container">
        <label for="password">Password</label>
        <input name="password" type="password" v-model="password" />
      </div>

      <div class="input-container">
        <label for="password">Confirm password</label>
        <input name="password" type="password" v-model="confirmation_password" />
      </div>

      <div class="actions-container">
        <button class="secondary-button">
          Sign up
        </button>
      </div>

      <div class="extra-options">
        <span>
          Have an account?

          <button class="primary-link-button" @click="handleSignIn">Sign in.</button>
        </span>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .sign-up-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 70vh;
  }

  .posts-modal-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    width: 340px;
    padding: 8px;
  }

  .posts-modal-header {
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
</style>