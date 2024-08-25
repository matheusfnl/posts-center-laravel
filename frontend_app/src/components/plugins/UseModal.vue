<script setup lang="ts">
  import { onMounted, ref, watch } from 'vue'
  import { useRoute } from 'vue-router';
  import { bus } from '@/plugins/bus-emitter';
  import type ModalParams from '@/interfaces/modal-params';
  import LoginModal from '@/components/modals/LoginModal.vue';

  const show_modal = ref(false);
  const modal_props = ref({});
  const modal_component = ref({});

  const handleClose = () => {
    show_modal.value = false;
    modal_props.value = {};
    modal_component.value = {};
  }

  onMounted(() => {
    bus.on('open-modal', (modal_params: ModalParams) => {
      show_modal.value = true;
      modal_props.value = modal_params.props || {};
      modal_component.value = modal_params.component;
    });

    bus.on('close-modal', handleClose);
  });

  const route = useRoute();

  watch(route, value => {
    handleClose();

    if (value.hash === '#login') {
      show_modal.value = true;
      return modal_component.value = LoginModal;
    }
  });
</script>

<template>
  <Transition name="fade">
    <div class="modal-wrapper" v-if="show_modal" @click="handleClose">
      <div class="modal-content" @click.stop>
        <component :is="modal_component" v-bind="modal_props" />
      </div>
    </div>
  </Transition>
</template>

<style scoped>
  .modal-wrapper {
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100vw;
    min-height: 100vh;
    z-index: 10000;
    background-color: var(--backdrop);
    backdrop-filter: blur(2px);
  }

  .modal-content {
    z-index: 2;
    background: var(--base-50);
    min-width: 200px;
    max-height: 100vh;
    border-radius: 8px;
    padding: 10px;
    overflow-y: auto;
  }

  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.2s ease;
  }

  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
</style>