import type { App } from 'vue';
import { bus } from './bus-emitter';
import type ModalParams from '../interfaces/modal-params';

export default {
  install: (app: App) => {
    app.config.globalProperties.$modal = {
      open: function(modalParams: ModalParams) {
        bus.emit('open-modal', modalParams);
      },

      close: function() {
        bus.emit('close-modal');
      },
    };
  }
}