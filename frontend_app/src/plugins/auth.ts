import type { App } from 'vue';
import { bus } from '@/plugins/bus-emitter';

export default {
  install: (app: App) => {
    app.config.globalProperties.$auth = {
      login: function() {
        bus.emit('login');
      },

      logout: function() {
        bus.emit('logout');
      },
    };
  }
}