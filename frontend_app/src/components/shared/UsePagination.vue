<script setup lang="ts">
import { computed, defineEmits } from 'vue';

  const emit = defineEmits<{(e: 'fetch', value: number): void}>();
  const props = defineProps({
    resource: {
      type: Object,
      required: true,
    },
  });

  const fetchData = (value: number|string) => emit('fetch', +value);
  const getActivePage = (page: number) => page === props.resource.current_page;

  const hasFirstButton = computed(() => props.resource.current_page > 3);
  const hasPrevButton =  computed(() => props.resource.current_page > 1);
  const hasNextButton  = computed(() => props.resource.current_page < props.resource.last_page);
  const getAvailablePages = computed(() => {
    const start = Math.max(1, props.resource.current_page - 2);
    const end = Math.min(props.resource.last_page, props.resource.current_page + 2);
    const pages = [];

    for (let i = start; i <= end; i++) {
      pages.push(i);
    }

    return pages;
  })
</script>

<template>
  <div class="pages-container" v-if="getAvailablePages.length > 1">
    <button @click="fetchData(1)" v-if="hasFirstButton">
      Start
    </button>

    <button @click="fetchData(props.resource.current_page - 1)" v-if="hasPrevButton">
      Prev
    </button>

    <button @click="fetchData(page)" v-for="page in getAvailablePages" :key="page" :class="{ 'active' : getActivePage(page) }">
      {{ page }}
    </button>

    <template v-if="hasNextButton">
      <button @click="fetchData(props.resource.current_page + 1)">
        Next
      </button>

      <button @click="fetchData(props.resource.last_page)">
        End
      </button>
    </template>
  </div>
</template>

<style scoped>
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