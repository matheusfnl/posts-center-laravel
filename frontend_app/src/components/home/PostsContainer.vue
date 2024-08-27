<script setup lang="ts">
  import { ref, computed, getCurrentInstance, onMounted } from 'vue';

  import PostItem from '@/components/home/PostItem.vue'
  import PostModal from '@/components/home/modals/PostModal.vue';
  import LoginModal from '@/components/modals/LoginModal.vue';

  import { usePostsStore } from '@/stores/posts';
  import { useAuthStore } from '@/stores/auth';

  import Spinner from '@/shared/SpinnerFeedback.vue';

  import { fetchPosts } from '@/api/fetchPosts';

  const { proxy } = getCurrentInstance() || {};
  const postsStore = usePostsStore();
  const authStore = useAuthStore();

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

  const hasFirstButton = computed(() => getPosts.value.current_page > 3);
  const hasPrevButton =  computed(() => getPosts.value.current_page > 1);
  const hasNextButton  = computed(() => getPosts.value.current_page < getPosts.value.last_page);
  const getAvailablePages = computed(() => {
    const start = Math.max(1, getPosts.value.current_page - 2);
    const end = Math.min(getPosts.value.last_page, getPosts.value.current_page + 2);
    const pages = [];

    for (let i = start; i <= end; i++) {
      pages.push(i);
    }

    return pages;
  })

  const getActivePage = (page: number) => page === getPosts.value.current_page;
  const fetchPostsData = async (page = 1) => {
    request_pending.value = true;
    const posts = await fetchPosts({
      page,
      sort: active_filter.value,
    });

    postsStore.setPosts(posts);
    request_pending.value = false;
  }

  // Post

  const getPosts = computed(() => postsStore.posts);
  const handleAddPost = () => {
    const user = authStore.user;
    const modal_component = user?.id ? PostModal : LoginModal;

    proxy?.$modal?.open({ component: modal_component });
  };

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
          {{ getPosts.total || 0 }} results
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

    <Spinner class="spinner-icon" v-if="request_pending" />

    <template v-else>
      <div class="posts-container">
        <PostItem v-for="post in getPosts.data" :key="post.id" :post="post" />
      </div>

      <div class="pages-container">
        <button @click="fetchPostsData(1)" v-if="hasFirstButton">
          Start
        </button>

        <button @click="fetchPostsData(getPosts.current_page - 1)" v-if="hasPrevButton">
          Prev
        </button>

        <button @click="fetchPostsData(page)" v-for="page in getAvailablePages" :key="page" :class="{ 'active' : getActivePage(page) }">
          {{ page }}
        </button>

        <template v-if="hasNextButton">
          <button @click="fetchPostsData(getPosts.current_page + 1)">
            Next
          </button>

          <button @click="fetchPostsData(getPosts.last_page)">
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

  .spinner-icon {
    margin: 32px 0;
    fill: var(--primary-500);
  }
</style>
