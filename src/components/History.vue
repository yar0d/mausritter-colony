<template>
  <div class="box background-white-75 is-flex is-flex-direction-column is-flex-grow-1">
    <div v-for="(line, index) in value" :key="index" class="is-flex is-flex-direction-column">
      <div class="is-flex is-flex-direction-row is-flex-wrap-wrap is-justify-content-space-between">
        <div class="has-text-weight-bold has-text-black">{{ header(line) }}</div>
        <div class="is-size-7">{{ line._date.toLocaleString(locale) }}</div>
      </div>

      <div class="is-flex is-flex-direction-row is-align-items-center is-flex-wrap-wrap is-justify-content-start">
        <div>
          <mc-icon v-if="line._json.success !== undefined || line._json.failed !== undefined" :icon="line._json.success === true ? 'success' : 'failed'" height="24" />
        </div>
        <div class="ml-1">
          {{ resume(line._json) }} <mc-icon icon="arrow-right" />
        </div>
        <div class="ml-2 is-size-5">
          <span class="has-text-weight-bold" :class="cls(line._json)">{{ line._json.total }}</span>
        </div>
        <div class="ml-2">
          {{ explain(line._json) }}
        </div>
      </div>
      <hr class="history-separator" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'History',
  props: {
    value: { type: Array, required: true }
  },
  data: () => ({}),
  computed: {
    locale () { return this.$store.getters['locale'] }
  },
  methods: {
    cls (roll) {
      if (roll.success) return 'px-2 has-background-success has-text-light'
      else if (roll.failed) return 'px-2 has-background-danger has-text-light'
      return 'px-2 boxed'
    },
    explain (diceResult) {
      let result = ''
      if (diceResult.score) {
        result = this.$t('Need {score} or lower.', { score: diceResult.score })
      } else if (diceResult.upper) {
        result = this.$t('Need {score} or upper.', { score: diceResult.upper })
      }

      if (diceResult.dices && diceResult.dices.length > 1) {
        result += ' (' + diceResult.dices.join(', ') + ')'
      }

      return result
    },
    header (roll) {
      return roll.vtable === roll.sheet ? this.$t('GM') : roll.sheet
    },
    resume (roll) {
      let result = roll.context ? roll.context + ' → ' : ''
      result += (roll.dices ? roll.dices.length : '') + (roll.faces ? 'D' + roll.faces + ' ' : '')
      return result.trim()
    }
  }
}
</script>
