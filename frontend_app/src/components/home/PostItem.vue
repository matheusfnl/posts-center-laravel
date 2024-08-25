<script setup lang="ts">
  import type Post from '@/interfaces/post';

  const props = defineProps<{ post: Post }>();
</script>

<template>
  <div class="post-container">
    <div class="post-info">
      <span>{{ props.post.upvotes_qtd || 0 }} Upvotes</span>
      <span>{{ props.post.downvotes_qtd || 0 }} Downvotes</span>
      <span>{{ props.post.comments_qtd || 0 }} Comments</span>
    </div>

    <div class="post-content">
      <router-link to="/post/id" class="title">
        {{ props.post.title }}
      </router-link>

      <span class="description">
        {{ props.post.description }}
      </span>
    </div>
  </div>
</template>

<style scoped>
  .post-container {
    border: 1px solid var(--base-300);
    border-radius: 6px;
    padding: 16px;
    display: flex;
    gap: 10px;
  }

  .post-info {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
    font-weight: 300;
    font-size: 12px;
    min-width: 100px;
  }

  .post-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .post-content .title {
    color: var(--primary-500);
    font-size: 16px;
    text-decoration: none;
  }

  .post-content .title:hover { color: var(--primary-600) }
  .post-content .description { font-size: 12px; }
</style>