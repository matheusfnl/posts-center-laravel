import { ModalParams } from '@/interfaces/modal-params'; // ajuste o caminho conforme necessário

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
    $modal: {
      open: (modalParams: ModalParams) => void;
      close: () => void;
    };
  }
}