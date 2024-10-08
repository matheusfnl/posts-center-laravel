import type Post from '@/interfaces/post';
import type Resource from '@/interfaces/resource';

import { defineStore } from 'pinia';

export const usePostsStore = defineStore('posts', {
  state: () => ({
    posts: {} as Resource,
    post: {} as Post,
  }),

  actions: {
    setPosts(posts: Resource) {
      this.posts = posts;
    },

    setNewPost(post: Post) {
      this.posts.data.unshift(post);
    },

    setPost(post: Post) {
      this.post = post;
    }
  },
});