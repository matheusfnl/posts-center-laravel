<script setup lang="ts">
  import { ref } from 'vue';

  const username = ref('');
  const password = ref('');
</script>

<template>
  <div class="posts-modal-container">
    <div class="posts-modal-header">
      Sign in
    </div>

    <div class="input-container">
      <label for="username">Username</label>
      <input name="username" type="text" v-model="username" />
    </div>

    <div class="input-container">
      <label for="password">Password</label>
      <input name="password" type="text" v-model="password" />
    </div>

    <div class="actions-container">
      <button @click="handleAddPost">
        Sign in
      </button>
    </div>

    <div class="extra-options">
      <span>
        Don't have an account?

        <a href="#">Create one</a>
      </span>
    </div>
  </div>
</template>

<style scoped>
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