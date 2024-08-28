<script lang="ts" setup>
  import { computed } from 'vue';
  import { useRoute } from 'vue-router';

  import EditIcon from '@/icons/EditIcon.vue';
  import DeleteIcon from '@/icons/DeleteIcon.vue';

  import { useAuthStore } from '@/stores/auth';

  import type Comment from '@/interfaces/comment';

  import { deletePostComment } from '@/api/deletePostComment';

  const props = defineProps<{ comment: Comment }>();
  const authStore = useAuthStore();
  const route = useRoute();
  const emit = defineEmits<{
    (e: 'edit', value: Comment): void,
    (e: 'delete', value: number): void
  }>();

  const getUser = computed(() => authStore.user);
  const isEdit = computed(() => props.comment.user_id === getUser.value?.id);

  const handleEdit = () => emit('edit', props.comment);
  const handleDelete = async () => {
    emit('delete', props.comment.id);

    await deletePostComment({
      id: +route.params.id,
      comment_id: props.comment.id,
    });
  };
</script>

<template>
  <div class="answer-item">
    <div class="answer-content">
      <div class="comment-header">
        <span class="name">{{ props.comment.user_name }}</span>

        <div class="post-actions" v-if="isEdit">
          <EditIcon @click="handleEdit" :size="16" />
          <DeleteIcon @click="handleDelete" :size="16" />
        </div>
      </div>
      <span class="answer">{{ props.comment.description }}</span>
    </div>
  </div>
</template>:

<style scoped>
  .answer-item {
    border: 1px solid var(--base-300);
    border-radius: 6px;
    padding: 16px;
    display: flex;
    gap: 10px;
  }

  .answer-item .answer-content {
    display: flex;
    flex-direction: column;
    gap: 10px;
    flex: 1;
  }

  .answer-item .answer-content .comment-header {
    display: flex;
    gap: 4px;
    align-items: center;
    justify-content: space-between;
  }

  .answer-item .answer-content .post-actions {
    display: flex;
    align-items: center;
    gap: 4px;
  }

  .answer-item .answer-content .post-actions svg { cursor: pointer;}
  .answer-item .answer-content .post-actions svg:hover * { stroke: var(--base-900) }
  .answer-item .answer-content .post-actions svg * { stroke: var(--text-500) }
  .answer-item .answer-content .name {
    font-size: 14px;
    color: var(--primary-600)
  }

  .answer-item .answer-content .answer { font-size: 12px; }
</style>