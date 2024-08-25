import { ModalParams } from '@/interfaces/modal-params';

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    $modal: {
      open: (modalParams: ModalParams) => void;
      close: () => void;
    };
  }
}
