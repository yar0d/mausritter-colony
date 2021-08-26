<template>
  <mc-icon :icon="'d' + faces" class="is-clickable" :height="height" @click="rollDice" />
</template>

<script>
import { roll } from '@/services/dice3d'
import { highestOfDices, lowestOfDices } from '@/services/dice-roller'

const STANDARD_DICES = [4, 6, 8, 10, 12, 20]

export default {
  name: 'Dice',
  props: {
    advantage: { type: String, default: '' },
    context: { type: String, default: '' },
    number: { type: Number, default: 1 },
    faces: { type: Number, default: 6 },
    height: { type: Number, default: 24 }
  },
  data () {
    return {
      roll: 0,
      show: false,
    }
  },
  computed: {
    icon () {
      return STANDARD_DICES.includes(this.faces) ? `mdi mdi-dice-d${this.faces}` : 'mdi mdi-dice-multiple'
    }
  },
  methods: {
    rollDice () {
      let number = this.advantage ? 2 : this.number
      roll({
        formula: `${number}d${this.faces}`,
        callbackFn: ({ dices, total }) => {
          this.roll = !this.advantage ? total : (this.advantage === 'a' ? lowestOfDices(dices) : highestOfDices(dices))
          this.$emit('rolled', { dices: dices, context: this.context, faces: this.faces, total: this.roll,  advantage: this.advantage  })
        }
      })
    }
  }
}
</script>
