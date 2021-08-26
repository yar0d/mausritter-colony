import Vue from 'vue'
import VueResource from 'vue-resource';
import App from './App.vue'
import VueI18n from 'vue-i18n'
import messages from '@/locales'
import { DEFAULT_LOCALE, datetimeFormats, numberFormats } from '@/services/locales'

import { store } from './store'
import Icon from '@/components/Icon.vue'
import VTableInput from '@/components/VTableInput.vue'

require('@/assets/styles/main.scss')

Vue.config.productionTip = false

Vue.use(VueResource);

Vue.component('mc-icon', Icon)
Vue.component('mc-vtable-input', VTableInput)

// Create VueI18n instance with options
Vue.use(VueI18n)
const i18n = new VueI18n({
  locale: DEFAULT_LOCALE,
  messages: messages,
  numberFormats,
  datetimeFormats
})

new Vue({
  i18n,
  store,
  render: h => h(App),
}).$mount('#app')
