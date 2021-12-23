<template>
  <iconify-icon v-bind="$attrs" v-on="$listeners" :icon="icons[icon]" :class="isButton ? 'icon-middle is-clickable' : 'icon-middle'" />
</template>

<script>
/*
* Simplified Iconify Icon. You can use all its properties,
* see https://docs.iconify.design/implementations/vue/
*/

import icons from '../services/icons'
import IconifyIcon from '@iconify/vue'

export default {
  name: 'Sheet',
  components: { IconifyIcon },
  props: {
    icon: { type: String, required: true },
    isButton: { type: Boolean, default: false }
  },
  data () {
    return  {
      icons
    }
  }
}
</script>
