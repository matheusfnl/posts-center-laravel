<script lang="ts" setup>
  import { ref, getCurrentInstance, onMounted, computed } from 'vue';
  import { useRoute } from 'vue-router';

  import PostModal from '@/components/home/modals/PostModal.vue';
  import UsePagination from '@/components/shared/UsePagination.vue';
  import UserComment from '@/components/post/UserComment.vue';
  import Spinner from '@/shared/SpinnerFeedback.vue';

  import { useAuthStore } from '@/stores/auth';

  import UpIcon from '@/icons/UpIcon.vue';
  import DownIcon from '@/icons/DownIcon.vue';

  import { fetchPost } from '@/api/fetchPost';
  import { fetchPostComments } from '@/api/fetchPostComments';
  import { editVote } from '@/api/editVote';
  import { createVote } from '@/api/createVote';
  import { createPostComments } from '@/api/createPostComment';
  import { editPostComment } from '@/api/editPostComment';

  import type Post from '@/interfaces/post';
  import type Resource from '@/interfaces/resource';
  import type Vote from '@/interfaces/vote';
  import type Comment from '@/interfaces/comment';

  const { proxy } = getCurrentInstance() || {};
  const route = useRoute();
  const authStore = useAuthStore();

  const post = ref({} as Post)
  const comments = ref({} as Resource);
  const request_pending = ref(false);
  const comments_request_pending = ref(false);
  const response_request_pending = ref(false);
  const editing_id = ref(null as number|null);
  const response = ref('');
  const vote = ref({} as Vote);

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
  const fetchCommentsData = async (page = 1) => {
    comments_request_pending.value = true;
    comments.value = await fetchPostComments({
      id: +route.params.id,
      page,
    });

    comments_request_pending.value = false;
  }

  const voteSelected = (vote_type: string) => vote.value?.vote_type === vote_type;
  const setVote = async (vote_type: string) => {
    const params = {
      id: post.value.id,
      vote_type,
    };

    if (vote.value) {
      vote.value.vote_type = vote_type;
      vote.value = await editVote({
        ...params,
        vote_id: vote.value.id,
      });
    } else {
      vote.value = { vote_type } as any;
      vote.value = await createVote(params);
    }
  };

  const handleAddPost = async () => {
    response_request_pending.value = true;

    if (editing_id.value) {
      const new_post = await editPostComment({
        id: +route.params.id,
        comment_id: editing_id.value,
        description: response.value,
      });

      comments.value.data = comments.value.data.map(post => post.id === editing_id.value ? new_post : post);
      editing_id.value = null;
    } else {
      const post = await createPostComments({
        id: +route.params.id,
        description: response.value,
      });

      comments.value.total++;
      comments.value.data.unshift(post);
    }

    response.value = '';
    response_request_pending.value = false;
  };

  const handleCommentDeleted = (id: number) => {
    comments.value.total--;
    comments.value.data = comments.value.data.filter(comment => +comment.id !== id);

    if (editing_id.value === id) {
      editing_id.value = null;
      response.value = '';
    }
  }

  const handleCommentEdit = (comment: Comment) => {
    editing_id.value = comment.id;
    response.value = comment.description;
  }

  const handleCancelEdit = () => {
    editing_id.value = null;
    response.value = '';
  }

  const getUser = computed(() => authStore.user);
  const getCreatedAt = computed(() => formatDate(post.value.created_at));
  const getUpdatedAt = computed(() => formatDate(post.value.updated_at));
  const hasChanges = computed(() => post.value.created_at !== post.value.updated_at);
  const canEditPost = computed(() => post.value.user_id === getUser.value?.id);
  const getCommets = computed(() => comments.value.data || []);
  const getPostResponseLabel = computed(() => editing_id.value ? 'Edit response' : 'Send response')
  const postResponseButtonDisabled = computed(() => {
    return ! response.value ||
    (editing_id.value && response.value === comments.value.data
      .find(comment => comment.id === editing_id.value).description);
  });

  onMounted(async () => {
    request_pending.value = true;
    const results = await Promise.allSettled([
      fetchPost({ id: +route.params.id }),
      fetchCommentsData(),
    ]);

    if (results[0].status === 'fulfilled') {
      post.value = results[0].value as Post;
      vote.value  = results[0].value.vote;
    }

    request_pending.value = false;
  });
</script>

<template>
  <div class="post-wrapper">
    <Spinner class="custom-spinner" v-if="request_pending" />

    <template v-else>
      <div class="post-header">
        <div class="answer-options">
          <div class="option" :class="{ 'selected' : voteSelected('upvote') }" @click="setVote('upvote')">
            <UpIcon :size="22" />
          </div>

          <div class="option" :class="{ 'selected' : voteSelected('downvote') }" @click="setVote('downvote')">
            <DownIcon :size="22" />
          </div>
        </div>

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

        <textarea name="answer" rows="9" v-model="response" />

        <div class="send-form">
          <button class="skinny-button" v-if="editing_id" @click="handleCancelEdit">
            Cancel
          </button>

          <button class="secondary-button response-button" :disabled="postResponseButtonDisabled" @click="handleAddPost">
            <Spinner :size="16" class="spinner-icon" v-if="response_request_pending" />
            <template v-else>{{ getPostResponseLabel }}</template>
          </button>
        </div>
      </div>

      <div class="answers-wrapper">
        <span>{{ comments.total }} responses</span>

        <Spinner v-if="comments_request_pending" />

        <div class="empty-container" v-else-if="! getCommets.length">
          Post without comments
        </div>

        <template v-else>
          <div class="answers-container">
            <UserComment v-for="comment in getCommets" :key="comment.id" :comment="comment" @delete="handleCommentDeleted" @edit="handleCommentEdit" />
          </div>

          <UsePagination @fetch="fetchCommentsData" :resource="comments" />
        </template>
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
    align-items: flex-start;
  }

  .post-header .answer-options {
    display: flex;
    flex-direction: column;
    gap: 2px;
    margin-top: 4px;
  }

  .post-header .answer-options .option {
    cursor: pointer;
    display: flex;
  }

  .post-header .answer-options .option * { stroke: var(--text-500); }
  .post-header .answer-options .option:hover * { stroke: var(--primary-500); }
  .post-header .answer-options .option.selected * { stroke: var(--primary-500); }
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
  .answer-form-container .send-form {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
  }

  .answer-form-container .send-form .response-button { min-width: 115px }
  .answers-wrapper {
    margin: 32px 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .answers-wrapper .empty-container {
    display: flex;
    justify-content: center;
    color: var(--base-800);
    font-style: italic;
  }

  .answers-wrapper .answers-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .spinner-icon { fill: var(--base-50); }
</style>