<script setup lang="ts">
  import { ref } from 'vue';

  const title = ref('');
  const description = ref('');
</script>

<template>
  <div class="posts-modal-container">
    <div class="posts-modal-header">
      <span class="title">
        Adding a post
      </span>

      <span class="description">
        Describe how you came across the problem you're facing. Include any challenges or obstacles that have made it difficult for you to resolve it on your own.
      </span>
    </div>

    <div class="input-container">
      <label for="title">Title</label>
      <input name="title" type="text" v-model="title" />
      <span>Provide a detailed question as if you were asking it to someone directly</span>
    </div>

    <div class="input-container" :class="{ 'disabled-container' : ! title }">
      <label for="description">Description</label>
      <textarea name="description" rows="6" v-model="description" :disabled="! title" />
      <span>Present the issue and elaborate on what was stated in the title. Minimum of 20 characters.</span>
    </div>

    <div class="actions-container">
      <button @click="handleAddPost" :disabled="! title || description.length < 20">
        Add post
      </button>
    </div>
  </div>
</template>

<style scoped>
  .posts-modal-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 600px;
  }

  .posts-modal-header {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .posts-modal-header .title {
    font-size: 18px;
  }

  .posts-modal-header .description {
    font-size: 12px;
  }

  .input-container {
    display: flex;
    flex-direction: column;
    gap: 4px;
    border: 1px solid var(--base-500);
    border-radius: 6px;
    padding: 8px;
  }

  .input-container input { height: 28px; }
  .input-container input, .input-container textarea {
    border: 1px solid var(--base-200);
    border-radius: 4px;
    font-size: 12px;
    resize: none;
  }

  .input-container span {
    font-size: 10px;
    color: var(--base-900);
  }

  .input-container.disabled-container {
    opacity: .5;
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
  }

  .actions-container button:hover {
    background-color: var(--secondary-600);
  }

  .actions-container button:disabled  {
    background-color: var(--secondary-200);
  }
</style>