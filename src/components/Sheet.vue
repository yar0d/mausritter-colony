<template>
  <div class="card">
    <header class="card-header">
      <div class="card-header-title is-flex is-flex-direction row is-justify-content-space-between mx-1 p-0">
        <mc-icon icon="mouse-face" height="48" />

        <div class="ml-1 is-flex is-flex-direction-column">
          <div class="is-size-5">{{ sheetName }}</div>
          <div>{{ $t('Level') }} {{ level }} {{ sheetBackground }}</div>
          <div class="is-size-7">{{ $t('Last update:') }} {{ lastUpdate.toLocaleString(locale) }}</div>
        </div>

        <div class="ml-4 ">
          <div class="dropdown" :class="deleteMenu ? 'is-active' : ''">
            <div class="dropdown-trigger">
              <mc-icon icon="menu" class="is-clickable" :class="deleteMenu ? 'boxed' : ''" height="24" @click="deleteMenu = !deleteMenu" />
            </div>
            <div class="dropdown-menu" id="dropdown-menu" role="menu">
              <div class="dropdown-content">
                <a href="#" class="dropdown-item" @click="remove">
                  {{ $t('Remove from table') }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <div class="card-content m-0 py-0 px-1">
      <div class="content">
        <table class="table is-striped has-text-centered">
          <tbody>
            <tr class="is-size-7"><td></td><td>{{ $t('Max') }}</td><td class="has-text-info">{{ $t('Current') }}</td></tr>
            <tr><td class="has-text-left has-text-weight-bold">{{ $t('STR') }}</td><td>{{ str_max }}</td><td class="is-size-5 has-text-info">{{ str }}</td></tr>
            <tr><td class="has-text-left has-text-weight-bold">{{ $t('DEX') }}</td><td>{{ dex_max }}</td><td class="is-size-5 has-text-info">{{ dex }}</td></tr>
            <tr><td class="has-text-left has-text-weight-bold">{{ $t('WIL') }}</td><td>{{ wil_max }}</td><td class="is-size-5 has-text-info">{{ wil }}</td></tr>
            <tr><td class="has-text-left has-text-weight-bold">{{ $t('HP') }}</td><td>{{ hp_max }}</td><td class="is-size-5 has-text-info">{{ hp }}</td></tr>
          </tbody>
        </table>
      </div>

      <div class="content is-flex is-justify-content-space-between">
        <label class="checkbox">
          {{ $t('Injured') }}
          <input type="checkbox">
        </label>
        <label class="ml-4 checkbox">
          {{ $t('Mad') }}
          <input type="checkbox">
        </label>
        <label class="ml-4 checkbox">
          {{ $t('Encumbered') }}
          <input type="checkbox">
        </label>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Sheet',
  props: {
    dex: { type: Number, required: true },
    dex_max: { type: Number, required: true },
    hp: { type: Number, required: true },
    hp_max: { type: Number, required: true },
    lastUpdate: { type: Date, required: true },
    level: { type: Number, required: true },
    name: { type: String, required: true },
    str: { type: Number, required: true },
    str_max: { type: Number, required: true },
    wil: { type: Number, required: true },
    wil_max: { type: Number, required: true }
  },
  data: () => ({
    deleteMenu: false
  }),
  computed: {
    locale () { return this.$store.getters['locale'] },
    sheetBackground () {
      const i = this.name.indexOf('(') || this.name.indexOf('—')
      if (!this.name || !i) return ''
      return this.name.slice(i, this.name.length)
    },
    sheetName () {
      const i = this.name.indexOf('(') || this.name.indexOf('—')
      if (!this.name || !i) return this.name
      return this.name.slice(0, i)
    }
  },
  methods: {
    remove () {
      this.$emit('remove', { name: this.name })
      this.$nextTick(() => { this.deleteMenu = false })
    }
  }
}
</script>
