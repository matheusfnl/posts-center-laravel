<script lang="ts" setup>
  import { ref, getCurrentInstance, onMounted, computed } from 'vue';
  import { useRoute } from 'vue-router';

  import PostModal from '@/components/home/modals/PostModal.vue';
  import Spinner from '@/shared/SpinnerFeedback.vue';

  import { useAuthStore } from '@/stores/auth';

  import UpIcon from '@/icons/UpIcon.vue';
  import DownIcon from '@/icons/DownIcon.vue';

  import { fetchPost } from '@/api/fetchPost';

  import type Post from '@/interfaces/post';

  const { proxy } = getCurrentInstance() || {};
  const route = useRoute();
  const authStore = useAuthStore();

  const post = ref({} as Post)
  const request_pending = ref(false);

  const formatDate = (date_string: string) => {
    const date = new Date(date_string);

    if (isNaN(date.getTime())) {
      return 'N/A';
    }

    const date_part = date.toLocaleDateString('pt-BR', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric',
    });

    const time_part = date.toLocaleTimeString('pt-BR', {
      hour: '2-digit',
      minute: '2-digit',
    });

    return `${date_part} ${time_part}`;
  };

  const handleEditPost = () => proxy?.$modal?.open({
    component: PostModal,
    props: {
      edit_post: post.value,
      edit_action: handleEdited,
    }
  });

  const handleEdited = (new_post: Post) => post.value = new_post;

  const getUser = computed(() => authStore.user);
  const getCreatedAt = computed(() => formatDate(post.value.created_at));
  const getUpdatedAt = computed(() => formatDate(post.value.updated_at));
  const hasChanges = computed(() => post.value.created_at !== post.value.updated_at);
  const canEditPost = computed(() => post.value.user_id === getUser.value.id);

  onMounted(async () => {
    request_pending.value = true;
    post.value = await fetchPost({ id: +route.params.id })

    request_pending.value = false;
  });
</script>

<template>
  <div class="post-wrapper">
    <Spinner class="custom-spinner" v-if="request_pending" />

    <template v-else>
      <div class="post-header">
        <div class="title-header">
          <span class="title">
            {{ post.title }}
          </span>

          <div class="post-info">
            <div class="date-info">
              <span class="label">Asked</span>
              <span>{{ getCreatedAt }}</span>
            </div>

            <div class="date-info" v-if="hasChanges">
              <span class="label">Modified</span>
              <span>{{ getUpdatedAt }}</span>
            </div>
          </div>
        </div>

        <div class="actions-container" v-if="canEditPost">
          <button class="secondary-button" @click="handleEditPost">
            Edit post
          </button>
        </div>
      </div>

      <div class="post-body">
        {{ post.description }}
      </div>

      <hr />

      <div class="answer-form-container">
        <span>Your response</span>

        <textarea name="answer" rows="9" />
      </div>

      <div class="answers-wrapper">
        <span>43 responses</span>

        <div class="answers-container">
          <div class="answer-item">
            <div class="answer-content">
              <span class="name">User name</span>

              <span class="answer">
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Atque perferendis explicabo temporibus, alias placeat odio maxime optio voluptatibus velit aliquam laborum quam. Iusto quam, in doloribus veritatis ipsum itaque eum.
                <br />
                <br />
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Soluta, minus culpa incidunt eos nostrum veritatis quidem, deserunt a neque repellendus modi. Placeat earum cumque sed hic suscipit optio nulla omnis?
              </span>
            </div>

            <div class="answer-options">
              <div class="option">
                <UpIcon :size="22" />
              </div>

              <div class="option">
                <DownIcon :size="22" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<style scoped>
  hr {
    margin: 32px 0;
    border: none;
    border-top: 1px solid var(--base-500);;
  }

  .post-wrapper {
    max-width: 756px;
    margin: auto;
  }

  .custom-spinner { margin-top: 32px; }
  .post-header {
    margin-top: 32px;
    display: flex;
    gap: 10px;
  }

  .post-header .title-header { flex: 1; }
  .post-header .title-header .title { font-size: 24px; }
  .post-header .title-header .post-info {
    display: flex;
    gap: 10px;
    margin-top: 10px;
  }

  .post-header .title-header .post-info .date-info {
    display: flex;
    gap: 4px;
    font-weight: 300;
    font-size: 12px;
  }

  .post-header .title-header .post-info .date-info .label { color: var(--base-900); }
  .post-header .actions-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .post-body {
    margin-top: 32px;
    font-size: 12px;
  }

  .answer-form-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .answer-form-container textarea { resize: vertical; }
  .answers-wrapper {
    margin-top: 32px;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .answers-wrapper .answers-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .answers-wrapper .answers-container .answer-item {
    border: 1px solid var(--base-300);
    border-radius: 6px;
    padding: 16px;
    display: flex;
    gap: 10px;
  }

  .answers-wrapper .answers-container .answer-item .answer-content {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .answers-wrapper .answers-container .answer-item .answer-content .name {
    font-size: 14px;
    color: var(--primary-600)
  }

  .answers-wrapper .answers-container .answer-item .answer-content .answer { font-size: 12px; }
  .answers-wrapper .answers-container .answer-item .answer-options {
    display: flex;
    flex-direction: column;
    gap: 2px;
  }

  .answers-wrapper .answers-container .answer-item .answer-options .option {
    cursor: pointer;
    display: flex;
  }

  .answers-wrapper .answers-container .answer-item .answer-options .option * { stroke: var(--text-500); }
  .answers-wrapper .answers-container .answer-item .answer-options .option:hover * { stroke: var(--primary-500); }
</style>