<script setup lang="ts">
  import { ref, computed, getCurrentInstance, onMounted } from 'vue';

  import type Resource from '@/interfaces/resource';

  import PostItem from '@/components/home/PostItem.vue'
  import PostModal from '@/components/home/modals/PostModal.vue';

  import Spinner from '@/shared/SpinnerFeedback.vue';

  import { fetchPosts } from '@/api/fetchPosts';

  const { proxy } = getCurrentInstance() || {};

  // Filter

  const active_filter = ref('');
  const filters = ref([
    { value: '', name: 'Newest' },
    { value: 'popular', name: 'Popular' },
    { value: 'positive', name: 'Positive' },
    { value: 'negative', name: 'Negative' },
    { value: 'answered', name: 'Answered' }
  ]);

  const getActiveFilter = (filter: string) => active_filter.value === filter;
  const setFilter = (filter: string) => {
    active_filter.value = filter;
    fetchPostsData();
  };

  // Pagination

  const request_pending = ref(false);

  const hasFirstButton = computed(() => posts_data.value.current_page > 3);
  const hasPrevButton =  computed(() => posts_data.value.current_page > 1);
  const hasNextButton  = computed(() => posts_data.value.current_page < posts_data.value.last_page);
  const getAvailablePages = computed(() => {
    const start = Math.max(1, posts_data.value.current_page - 2);
    const end = Math.min(posts_data.value.last_page, posts_data.value.current_page + 2);
    const pages = [];

    for (let i = start; i <= end; i++) {
      pages.push(i);
    }

    return pages;
  })

  const getActivePage = (page: number) => page === posts_data.value.current_page;
  const fetchPostsData = async (page = 1) => {
    request_pending.value = true;
    posts_data.value = await fetchPosts({
      page,
      sort: active_filter.value,
    });

    request_pending.value = false;
  }

  // Post

  const posts_data = ref({} as Resource);
  const handleAddPost = () => proxy?.$modal?.open({ component: PostModal });

  // Mounted

  onMounted(() => fetchPostsData())
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
        <button class="secondary-button" @click="handleAddPost">
          Add post
        </button>

        <div class="filters-container">
          <button v-for="(filter, index) in filters" :key="index" :class="{ 'active' : getActiveFilter(filter.value) }" @click="setFilter(filter.value)">
            {{ filter.name }}
          </button>
        </div>
      </div>
    </div>

    <Spinner v-if="request_pending" />

    <template v-else>
      <div class="posts-container">
        <PostItem v-for="post in posts_data.data" :key="post.id" :post="post" />
      </div>

      <div class="pages-container">
        <button @click="fetchPostsData(1)" v-if="hasFirstButton">
          Start
        </button>

        <button @click="fetchPostsData(posts_data.current_page - 1)" v-if="hasPrevButton">
          Prev
        </button>

        <button @click="fetchPostsData(page)" v-for="page in getAvailablePages" :key="page" :class="{ 'active' : getActivePage(page) }">
          {{ page }}
        </button>

        <template v-if="hasNextButton">
          <button @click="fetchPostsData(posts_data.current_page + 1)">
            Next
          </button>

          <button @click="fetchPostsData(posts_data.last_page)">
            End
          </button>
        </template>
      </div>
    </template>
  </div>
</template>

<style scoped>
  .posts-wrapper {
    margin: 32px auto;
    max-width: 756px;
  }

  .posts-header {
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

  .posts-header .filters-wrapper .filters-container {
    border: 1px solid var(--base-300);
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
    background-color: var(--base-400);
  }

  .posts-header .filters-wrapper .filters-container button:focus {
    border: none;
    outline: none;
  }

  .posts-header .filters-wrapper .filters-container button.active {
    background-color: var(--base-500);
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
    border: 1px solid var(--base-300);
    border-radius: 6px;
    padding: 4px 6px;
  }

  .pages-container button:hover {
    background-color: var(--base-400);
  }

  .pages-container button.active {
    background-color: var(--primary-500);
    color: var(--base-50);
    border: none;
  }
</style>
