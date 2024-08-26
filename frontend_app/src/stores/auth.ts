import { defineStore } from 'pinia';

import type User from '@/interfaces/user';

export const useAuthStore = defineStore('auth', {
  state: () => ({ user: {} as User }),
  actions: {
    setUser(user: User) {
      this.user = user;
    },
  },
});