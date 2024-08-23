<script setup lang="ts">
  import { ref } from 'vue';

  const username = ref('');
  const password = ref('');
  const confirmation_password = ref('');
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
        <button @click="handleAddPost">
          Sign up
        </button>
      </div>

      <div class="extra-options">
        <span>
          Have an account?

          <router-link to="/">Sign in.</router-link>
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

  .input-container input { height: 28px; }
  .input-container input, .input-container textarea {
    border: 1px solid var(--base-200);
    border-radius: 4px;
    font-size: 12px;
    resize: none;
  }

  .actions-container {
    display: flex;
    justify-content: flex-end;
  }

  .actions-container button {
    border: none;
    background-color: var(--secondary-500);
    cursor: pointer;
    padding: 8px 10px;
    border-radius: 6px;
    color: var(--base-50);
    width: 100%;
    font-weight: 500;
  }

  .actions-container button:hover {
    background-color: var(--secondary-600);
  }

  .extra-options {
    display: flex;
    justify-content: center;
    font-size: 12px;
    color: var(--base-800);
  }

  .extra-options a {
    color: var(--primary-500);
    text-decoration: none;
  }

  .extra-options a:hover {
    color: var(--primary-600);
    text-decoration: underline;
  }
</style>