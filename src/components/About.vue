<template>
  <div>
    <div class="modal" :class="innerShow ? 'is-active' : ''">
    <div class="modal-background"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">
            Mausritter Colony {{ version }}
            <span v-if="isStandaloneApp" color="brown">{{ $t('application') }}</span>
          </p>
          <button class="delete" aria-label="close" @click="innerShow = false"></button>
        </header>
        <section class="modal-card-body">
          <p class="mb-4">
            {{ $t('This application is an independent production by Daniel Coquette and is not affiliated with Losing Games. It is published under the Mausritter Third Party Licence.') }}
          </p>
          <p class="mb-4">{{ $t('Mausritter is copyright Losing Games.') }} {{ $t('This application is copyright Daniel Coquette.') }}</p>
          <p>{{ $t('3D dices from Anton Natarov') }} <a href="http://a.teall.info/mdice/">http://a.teall.info/mdice</a>.</p>
        </section>
        <footer class="modal-card-foot">
          <button class="button" @click="innerShow = false">{{ $t('Close') }}</button>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AboutBox',
  props: {
    show: { type: Boolean, default: false }
  },
  data () {
    return {
      innerShow: false,
      isStandaloneApp: false,
      version: null
    }
  },
  watch: {
    show (newValue) {
      this.innerShow = newValue
    }
  }
}
</script>