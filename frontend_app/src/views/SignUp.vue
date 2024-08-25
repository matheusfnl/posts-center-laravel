<script setup lang="ts">
  import { ref, computed, getCurrentInstance } from 'vue';
  import { useRouter } from 'vue-router';

  import Spinner from '@/shared/SpinnerFeedback.vue';

  import { register } from '@/api/register';

  const { proxy } = getCurrentInstance() || {};
  const router = useRouter()

  const username = ref('');
  const password = ref('');
  const confirmation_password = ref('');
  const email = ref('');
  const request_pending = ref(false);

  const signInDisabled = computed(() => ! username.value ||
    ! password.value ||
    ! confirmation_password.value ||
    ! email.value);

  const handleRegister = async () => {
    request_pending.value = true;
    await register({
      name: username.value,
      email: email.value,
      password: password.value,
      confirmation_password: confirmation_password.value,
    });

    request_pending.value = false;
    proxy?.$auth?.login();
    router.push('/');
  };
</script>

<template>
  <div class="sign-up-container">
    <div class="posts-modal-container">
      <div class="posts-modal-header">
        Sign up
      </div>

      <div class="input-container">
        <label for="username">Username</label>
        <input name="username" type="text" v-model="username" />
      </div>

      <div class="input-container">
        <label for="email">Email</label>
        <input name="email" type="email" v-model="email" />
      </div>

      <div class="input-container">
        <label for="password">Password</label>
        <input name="password" type="password" v-model="password" />
      </div>

      <div class="input-container">
        <label for="password">Confirm password</label>
        <input name="password" type="password" v-model="confirmation_password" />
      </div>

      <div class="actions-container">
        <button class="secondary-button" :disabled="signInDisabled" @click="handleRegister">
          <Spinner :size="16" class="spinner-icon" v-if="request_pending" />
          <template v-else>Sign up</template>
        </button>
      </div>

      <div class="extra-options">
        <span>
          Have an account?

          <router-link class="primary-link-button" to="/#login">Sign in.</router-link>
        </span>
      </div>
    </div>
  </div>
</template>

<style scoped>
  .sign-up-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 70vh;
  }

  .posts-modal-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    width: 340px;
    padding: 8px;
  }

  .posts-modal-header {
    display: flex;
    justify-content: center;
    font-size: 18px;
  }

  .input-container {
    display: flex;
    flex-direction: column;
    gap: 4px;
  }

  .actions-container {
    display: flex;
    justify-content: flex-end;
  }

  .actions-container button {
    width: 100%;
    font-weight: 500;
  }

  .extra-options {
    display: flex;
    justify-content: center;
  }

  .spinner-icon { fill: var(--base-50); }
</style>