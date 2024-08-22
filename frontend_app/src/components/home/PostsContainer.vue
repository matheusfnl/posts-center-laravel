<script setup lang="ts">
  import { ref, computed } from 'vue';
  import PostItem from './PostItem.vue'

  // Filter
  const active_filter = ref('newest');
  const filters = ref([
    { value: 'newest', name: 'Newest' },
    { value: 'positive', name: 'Positive' },
    { value: 'negative', name: 'Negative' },
    { value: 'answered', name: 'Answered' }
  ]);

  const getActiveFilter = (filter: String) => active_filter.value === filter;

  // Pages
  const active_page = ref(1);
  const total_pages = ref(10);
  const hasPrevButton =  computed(() => active_page.value > 1);
  const hasNextButton  = computed(() => active_page.value < total_pages.value);
  const getAvailablePages = computed(() => {
    const start = Math.max(1, active_page.value - 2);
    const end = Math.min(total_pages.value, active_page.value + 2);
    const pages = [];

    for (let i = start; i <= end; i++) {
      pages.push(i);
    }

    return pages;
  })

  const getActivePage = (page: number) => page === active_page.value;
</script>

<template>
  <div class="posts-wrapper">
    <div class="posts-header">
      <div class="section-title">
        <span class="title">
          All posts
        </span>

        <span class="info">
          469 results
        </span>
      </div>

      <div class="filters-wrapper">
        <button class="filter-button">
          Add post
        </button>

        <div class="filters-container">
          <button v-for="(filter, index) in filters" :key="index" :class="{ 'active' : getActiveFilter(filter.value) }">
            {{ filter.name }}
          </button>
        </div>
      </div>
    </div>

    <div class="posts-container">
      <PostItem />
      <PostItem />
    </div>

    <div class="pages-container">
      <button v-if="hasPrevButton">
        Prev
      </button>

      <button v-for="page in getAvailablePages" :key="page" :class="{ 'active' : getActivePage(page) }">
        {{ page }}
      </button>

      <button v-if="hasNextButton">
        Next
      </button>
    </div>
  </div>
</template>

<style scoped>
  .posts-wrapper {
    max-width: 756px;
    margin: auto;
  }

  .posts-header {
    margin-top: 32px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
  }

  .posts-header .section-title {
    display: flex;
    flex-direction: column;
    gap: 4px;
    margin-bottom: 8px;
  }

  .posts-header .section-title .title { font-size: 24px; }
  .posts-header .section-title .info { font-weight: 300; }
  .posts-header .filters-wrapper {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
  }

  .posts-header .filters-wrapper button.filter-button {
    border: none;
    background-color: rgb(104, 104, 255);
    cursor: pointer;
    padding: 8px 10px;
    border-radius: 6px;
    color: white;
  }

  .posts-header .filters-wrapper button.filter-button:hover {
    background-color: rgb(92, 92, 238);
  }

  .posts-header .filters-wrapper .filters-container {
    border: 1px solid rgb(211, 211, 211);
    border-radius: 6px;
    margin-bottom: 8px;
    padding: 4px;
    display: flex;
    gap: 4px;
  }

  .posts-header .filters-wrapper .filters-container button {
    border: none;
    background-color: transparent;
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
  }

  .posts-header .filters-wrapper .filters-container button:hover {
    background-color: rgb(243, 243, 243);
  }

  .posts-header .filters-wrapper .filters-container button.active {
    background-color: rgb(235, 235, 235);
  }

  .posts-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .pages-container {
    margin-top: 8px;
    display: flex;
    gap: 4px;
  }

  .pages-container button {
    background-color: transparent;
    cursor: pointer;
    border: 1px solid rgb(211, 211, 211);
    border-radius: 6px;
    padding: 4px 6px;
  }

  .pages-container button:hover {
    background-color: rgb(243, 243, 243);
  }

  .pages-container button.active {
    background-color: rgb(255, 152, 16);
    color: white;
    border: none;
  }
</style>
