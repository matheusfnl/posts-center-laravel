<script setup lang="ts">
  import { ref, computed } from 'vue';
  import { useRouter } from 'vue-router';

  import Spinner from '@/shared/SpinnerFeedback.vue';

  import { register } from '@/api/register';

  import { useAuthStore } from '@/stores/auth';

  import type ExtendedError from '@/interfaces/extended-error';
  import type ApiError from '@/interfaces/api-error';

  const authStore = useAuthStore();
  const router = useRouter()

  const username = ref('');
  const password = ref('');
  const confirmation_password = ref('');
  const email = ref('');
  const request_pending = ref(false);
  const api_errors = ref<ApiError>({});

  const signInDisabled = computed(() => ! username.value ||
    ! password.value ||
    ! confirmation_password.value ||
    ! email.value);

  const handleRegister = async () => {
    request_pending.value = true;
    const user = await register({
      name: username.value,
      email: email.value,
      password: password.value,
      confirmation_password: confirmation_password.value,
    });

    request_pending.value = false;

    if (user instanceof Error) {
      const { response: { data: { errors = {} as ApiError } = {} } = {} } = user as ExtendedError;

      return api_errors.value = errors;
    }

    authStore.setUser(user);
    router.push('/');
  };

  const getHasError = (field: string) => {
    if (api_errors.value?.[field]?.length) {
      return api_errors.value[field][0];
    }

    return '';
  }
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
        <span class="error-feedback" v-if="getHasError('email')">{{ getHasError('email') }}</span>
      </div>

      <div class="input-container">
        <label for="password">Password</label>
        <input name="password" type="password" v-model="password" />
        <span class="error-feedback" v-if="getHasError('password')">{{ getHasError('password') }}</span>
      </div>

      <div class="input-container">
        <label for="confirmation_password">Confirm password</label>
        <input name="confirmation_password" type="password" v-model="confirmation_password" />
        <span class="error-feedback" v-if="getHasError('confirmation_password')">{{ getHasError('confirmation_password') }}</span>
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

  .input-container .error-feedback {
    color: var(--error-500);
    font-size: 12px;
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