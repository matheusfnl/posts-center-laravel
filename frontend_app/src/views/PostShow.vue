<script lang="ts" setup>
  import { getCurrentInstance } from 'vue';

  import PostModal from '@/components/home/modals/PostModal.vue';

  import UpIcon from '@/icons/UpIcon.vue';
  import DownIcon from '@/icons/DownIcon.vue';

  const { proxy } = getCurrentInstance() || {};

  const handleEditPost = () => proxy?.$modal?.open({ component: PostModal });
  const handleAddPost = () => proxy?.$modal?.open({ component: PostModal });
</script>

<template>
  <div class="post-wrapper">
    <div class="post-header">
      <div class="title-header">
        <span class="title">
          How to conditionally format non-adjacent cells in Microsoft Excel based on the second highest value
        </span>

        <div class="post-info">
          <div class="date-info">
            <span class="label">Asked</span>
            <span>Date</span>
          </div>

          <div class="date-info">
            <span class="label">Modified</span>
            <span>Date</span>
          </div>
        </div>
      </div>

      <div class="actions-container">
        <button class="primary-button" @click="handleEditPost">
          Edit post
        </button>

        <button class="secondary-button" @click="handleAddPost">
          Add post
        </button>
      </div>
    </div>

    <div class="post-body">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores dolorum, odit alias ipsam facilis modi laboriosam illo ad a vitae, dicta reprehenderit error adipisci nulla ipsum quis iste praesentium perferendis!
      <br />
      <br />
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Molestias perferendis iusto soluta doloribus magnam modi id illum laudantium. Doloribus ipsa vero provident blanditiis sint est mollitia unde harum deleniti pariatur!
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Quasi, esse! Consequatur, eum maxime aut ipsum architecto cumque, atque assumenda minus rem modi voluptatem! Et tempora omnis vel, reiciendis perferendis tempore.
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