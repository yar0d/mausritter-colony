<template>
  <div>
    <div class="is-flex is-flex-direction-row is-align-items-center">
      <div>
        <table class="tracker">
          <thead v-if="title">
            <tr class="is-size-5 has-text-centered">
              <th :colspan="canClear ? 5 : 6">{{ title }}</th>
              <th v-show="canClear" colspan="1">
                <mc-icon is-button icon="trash" height="24" @click="clearTracker" />
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, y) in value" :key="'row-' + y">
              <td v-if="showTurnNumber">{{ y + 1 }}</td>
              <td v-for="(cell, x) in row" :key="'cell-' + x + '-' + y" class="is-clickable has-text-centered" @click="setValue(y, x)">
                <div class="is-align-items-center is-justify-content-center is-flex tracker-cell" :class="getClass(y, x)">
                  <tracker-turn v-model="value[y][x]" />
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div v-if="titleLeft" class="tracker-left-title is-vertical">
        <p :class="titleLeftBold ? 'has-text-weight-bold' : ''">{{ titleLeft }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import { trackerTurnColorClass } from '@/services/tracker'
import TrackerTurn from './TrackerTurn.vue'

export default {
  components: { TrackerTurn },
  name: 'TrackerWatch',
  props: {
    canClear: { type: Boolean, default: false },
    showTurnNumber: { type: Boolean, default: false },
    title: { type: String, default: '' },
    titleLeft: { type: String, default: '' },
    titleLeftBold: { type: Boolean, default: false },
    value: { type: Array, required: true }
  },
  data () { return {} },
  methods: {
    clearTracker () {
      this.$emit('clear')
    },
    getClass (y, x) {
      return (y === 2 || y === 5 ? 'encounter' : '') + ' ' + trackerTurnColorClass(this.value[y][x])
    },
    setValue (y, x) {
      this.$emit('change', { y, x })
    }
  }
}
</script>
