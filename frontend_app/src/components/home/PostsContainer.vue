<script setup lang="ts">
  import PostItem from './PostItem.vue'
</script>

<template>
  <div class="posts-wrapper">
    <div class="section-title">
      <span class="title">
        All posts
      </span>

      <span class="info">
        469 posts
      </span>
    </div>

    <div class="posts-container">
      <PostItem />
      <PostItem />
    </div>
  </div>
</template>

<style scoped>
  .posts-wrapper {
    max-width: 756px;
    margin: auto;
  }

  .section-title {
    margin-top: 32px;
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .section-title .title { font-size: 24px; }
  .section-title .info { font-weight: 300; }

  .posts-container {
    margin-top: 32px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
</style>
