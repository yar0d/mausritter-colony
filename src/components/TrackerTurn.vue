<template>
  <mc-icon v-show="innerValue" :icon="trackerTurnIcon(innerValue)" :height="28" />
</template>

<script>
import { TURN_TRACKER_EMPTY, trackerTurnIcon } from '@/services/tracker'

export default {
  name: 'TrackerTurn',
  props: {
    value: { type: Number, default: 0 }
  },
  data () {
    return {
      innerValue: TURN_TRACKER_EMPTY,
      trackerTurnIcon
    }
  },
  watch: {
    value:{
      immediate: true,
      handler (newValue) {
        if (!isNaN(newValue)) this.innerValue = newValue
      }
    }
  }
}
</script>