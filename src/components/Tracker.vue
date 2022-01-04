<template>
  <div class="is-flex is-flex-wrap-wrap">
    <tracker-watch :title="$t('Night watch')" :title-left="$t('Sunrise')" can-clear title-left-bold v-model="night" @change="onChange('night', ...arguments)" @clear="onClear('night')" />
    <tracker-watch :title="$t('Morning watch')" :title-left="$t('Noon')" v-model="morning" can-clear @change="onChange('morning', ...arguments)" @clear="onClear('morning')" />
    <tracker-watch :title="$t('Afternoon watch')" :title-left="$t('Sunset')" can-clear title-left-bold v-model="afternoon" @change="onChange('afternoon', ...arguments)" @clear="onClear('afternoon')" />
    <tracker-watch :title="$t('Evening watch')" v-model="evening" can-clear @change="onChange('evening', ...arguments)" @clear="onClear('evening')" />
  </div>
</template>

<script>
import { TURN_TRACKER_LAST } from '@/services/tracker'
import TrackerWatch from './TrackerWatch.vue'

export default {
  components: { TrackerWatch },
  name: 'TurnTracker',
  data () {
    return {
      afternoon: this.newWatch(),
      evening: this.newWatch(),
      morning: this.newWatch(),
      night: this.newWatch()
    }
  },
  methods: {
    newWatch () {
      return [...[
        [0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0]
      ]]
    },
    onClear (watchName) {
      this[watchName] = this.newWatch()
      this.$store.dispatch('vtable/update', { data: this.serialize() })
    },
    onChange (watchName, { y, x }) {
      const tmp = [...this[watchName]]
      if (tmp[y][x] >= TURN_TRACKER_LAST) tmp[y][x] = 0
      else tmp[y][x]++
      this.$store.dispatch('vtable/update', { data: this.serialize() })
      // Force refreshing watch turn table
      this.set({
        [watchName]: [...tmp]
      })
    },
    serialize () {
      return {
        afternoon: this.afternoon,
        evening: this.evening,
        morning: this.morning,
        night: this.night
      }
    },
    set (data) {
      if (!data) return
      if (data.afternoon) this.afternoon = [...data.afternoon]
      if (data.evening) this.evening = [...data.evening]
      if (data.morning) this.morning = [...data.morning]
      if (data.night) this.night = [...data.night]
    }
  }
}
</script>
