<script setup lang="ts">
  import { onMounted, ref } from 'vue'
  import { bus } from '@/plugins/bus-emitter';
  import type ModalParams from '@/interfaces/modal-params';

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
    background-color: rgba(0, 0, 0, 0.1);
  }

  .modal-content {
    z-index: 2;
    background: white;
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