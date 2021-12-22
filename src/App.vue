<template>
  <div id="app" class="application-background">
    <div id="dice-canvas" class="dice3d-canvas" />

    <div class="is-flex is-flex-direction-row is-justify-content-start background-white-50 vertical-align px-2">
      <img max-height="32px" src="/img/logo.png">
      <div class="is-size-3 has-text-weight-bold mr-2">
        Mausritter-Colony
        <span class="px-2 has-background-danger has-text-white">BETA</span>
      </div>

      <button v-for="lang in LOCALES" :key="lang" class="button is-small mr-2" :class="locale === lang ? 'is-primary' : ''" @click="changeLocale(lang)">
        <mc-icon :icon="lang" height="24" class="mr-1"/>
        <span v-show="locale !== lang">{{ $t(lang) }}</span>
      </button>

      <a href="https://mausritter-sheet.dco.ninja" target="_blank">
        Mausritter-Sheet
      </a>

      <div class="is-flex is-flex-grow-1 is-justify-content-flex-end">
        <img :src="require('@/assets/img/compatible-with-mausritter-88x32.png')" contain class="is-clickable" @click="showAbout = true" />
      </div>
    </div>

    <div class="columns m-1">
      <div class="column is-half-tablet is-two-thirds-desktop">
        <div v-show="error" class="notification is-error">
          <button class="delete" @click="error = null" />
          {{ error }}
        </div>

        <div class="is-flex is-flex-direction-column">
          <accordion class="table-background">
            <template slot="header">
              {{ $t('Table') }}
            </template>

            <div slot="content" class="m-1">
              <div class="p-2 has-text-weight-normal">
                <p class="is-size-5 has-text-weight-bold">{{ $t('Welcome') }}</p>

                <div class="notification background-white-50">
                  <p>{{ $t('Mausritter-Colony is a very simple tool that will help you, the GM, to manage a Mausritter adventure. All unused data older than 3 months will be deleted.') }}</p>
                  <p>{{ $t('Mausritter-Colony is not a virtual tabletop. You will have to manually refresh the mice list and the dices history.') }}</p>
                  <p class="mt-2">
                    <span class="subtitle">{{ $t('To begin to play:') }}</span>
                    <ol>
                      <li>
                        {{ $t('Tell your player to create/load their mouse on') }} <a target="mausritter-sheet" href="https://mausritter-sheet.dco.ninja/">Mausritter Sheet</a>. {{ $t('At the top of the sheet, a table ID can be input.') }}
                        <img :src="require('@/assets/img/table-id-input.png')" contain />
                      </li>
                      <li>
                        <div>{{ $t('Share this table ID with your players:') }}
                          <span class="is-family-monospace has-text-weight-bold is-size-5 is-clickable ml-1" @click="copyToClipboard" :data-tooltip="$t('Click to copy to clipboard')">
                            {{ vtable }}
                            <mc-icon is-button icon="copy" class="ml-1" />
                          </span>
                          <div v-show="showNotifications" class="notification is-info is-light">
                            <button class="delete" @click="showNotifications = false" />
                            {{ $t('{name} is now copied to clipboard.', { name: vtable }) }}
                          </div>
                        </div>
                      </li>
                    </ol>
                  </p>
                </div>
              </div>
            </div>
          </accordion>

          <accordion class="table-background">
            <template slot="header">
              {{ $t('Turn tracker') }}
            </template>

            <template slot="header-append">
              <mc-icon is-button icon="help" height="24" @click="showHelp = !showHelp" />
            </template>

            <div slot="content" class="m-1">
              <div v-show="showNotifications" class="notification is-info is-light">
                <button class="delete" @click="showNotifications = false" />
                {{ $t('{name} is now copied to clipboard.', { name: vtable }) }}
              </div>

              <div>
                <tracker ref="turn-tracker" />
              </div>

              <transition name="fade">
                <div v-show="showHelp" class="m-2 mt-4 notification background-white-50 is-flex is-flex-wrap-wrap">
                  <button class="delete" @click="showHelp = false" />

                  <div>
                    <p >{{ $t('Click on a box to change its content.') }}</p>
                    <p class="is-align-items-center is-flex">
                      <mc-icon icon="light" height="20" class="mr-1" />
                      {{ $t('A turn using lighting with a torch or a lantern.') }}
                    </p>
                    <p class="is-align-items-center is-flex">
                      <mc-icon icon="paws" height="20" class="mr-1" />
                      {{ $t('A turn walking.') }}
                    </p>
                    <p class="is-align-items-center is-flex">
                      <mc-icon icon="food" height="20" class="mr-1" />
                      {{ $t('A turn to rest and eat.') }}
                    </p>
                  </div>

                  <div class="mx-4">
                    {{ $t('In a dungeon, roll d6 for encounter every three turns.') }}
                    <p>
                      {{ $t('1: Encounter, 2: Omen of encounter. Roll for type.') }}
                    </p>
                  </div>

                  <div>
                    {{ $t('In the wilderness, roll d6 for encounter at Sunrise and Sunset.') }}
                    <p>
                      {{ $t('If an encounter or omen is rolled, roll d12 to find the hour.') }}
                    </p>
                  </div>
                </div>
              </transition>
            </div>
          </accordion>

          <accordion class="table-background">
            <template slot="header">
              {{ $t('Mice') }} <span class="ml-2 tag is-rounded is-dark">{{ sheets.length }}</span>
            </template>

            <template slot="header-append">
              <mc-icon v-if="vtable" is-button icon="refresh" height="24" :class="isLoadingMice ? 'rotate' : ''" @click="refreshMice" />
            </template>

            <div slot="content">
              <div class="is-flex is-flex-wrap-wrap">
                <div v-if="sheets.length === 0" class="is-size-4 has-text-weight-bold m-4">
                  {{ $t('No player is connected. Refresh this panel with the double round arrows in its title.') }}
                </div>
                <div v-else v-for="(sheet, index) in sheets" :key="index" class="p-2">
                  <sheet :level="sheet.level" :dex="sheet.dex" :dex_max="sheet.dex_max" :hp="sheet.hp" :hp_max="sheet.hp_max" :last-update="sheet.updated" :name="sheet.name" :str="sheet.str"  :str_max="sheet.str_max" :wil="sheet.wil" :wil_max="sheet.wil_max" @remove="removeSheet" />
                </div>
              </div>
            </div>
          </accordion>
        </div>
      </div>

      <div class="column" :style="historyStyle">
        <div class="panel">
          <div class="panel-heading is-flex is-flex-direction-row is-justify-content-space-between">
            Dices
            <div class="is-flex is-flex-direction-row">
              <div class="buttons has-addons are-small">
                <button class="button small" :class="diceAdvantage === '' ? 'has-background-info has-text-info-light' : ''" @click="diceAdvantage = ''">{{ $t('neutral') }}</button>
                <button class="button" :class="diceAdvantage === 'a' ? 'has-background-info has-text-info-light' : ''" @click="diceAdvantage = 'a'">{{ $t('advantage') }}</button>
                <button class="button" :class="diceAdvantage === 'd' ? 'has-background-info has-text-info-light' : ''" @click="diceAdvantage = 'd'">{{ $t('disadvantage') }}</button>
              </div>
            </div>
          </div>

          <div class="notification panel-block">
            {{ $t('Roll dice') }}
            <div v-for="dice in DICE_FACES" :key="dice" class="mx-4 is-clickable">
              <dice :faces="dice" :advantage="diceAdvantage" :height="32" @rolled="diceRolled" color="blue" />
            </div>
          </div>
        </div>

        <div class="panel">
          <div class="panel-heading is-flex is-flex-direction-row is-justify-content-space-between">
            {{ $t('History') }}
            <mc-icon v-if="vtable" is-button icon="refresh" height="24" :class="isLoadingHistory ? 'rotate' : ''" @click="refreshHistory" />
          </div>

          <div class="panel-block">
            <history v-if="history.length" :value="history" />
          </div>
        </div>
      </div>
    </div>

    <about :show="showAbout" />
  </div>
</template>

<script>
import { v4 as uuidv4, v5 as uuidv5 } from 'uuid';
import { LOCALES, DEFAULT_LOCALE, loadLocale, saveLocale } from '@/services/locales'
import { copyToClipboard } from '@/services/clipboard'
import { PREF_VTABLE_ID } from '@/services/defines'
import dices3D from '@/services/dice3d'
import Dice from '@/components/Dice.vue'
import Sheet from './components/Sheet.vue'
import Tracker from './components/Tracker.vue'
import History from './components/History.vue'
import Accordion from './components/Accordion.vue'
import About from './components/About.vue'

const DICE_FACES = [4, 6, 8, 10, 12, 20]

export default {
  name: 'App',
  components: { About, Sheet, Tracker, History, Accordion, Dice },
  data () {
    return {
      DEFAULT_LOCALE,
      DICE_FACES,
      LOCALES,
      diceAdvantage: '',
      error: null,
      expandTurnTracker: true,
      isLoadingHistory: false,
      isLoadingMice: false,
      locale: null,
      showAbout: false,
      showHelp: true,
      showNotifications: false,
      window
    }
  },
  computed: {
    history () { return this.$store.getters['history/list']  },
    historyStyle () { return null /* `{ max-height: ${window.innerHeight} !important; overflow-y: scroll; }` */ },
    prefs () { return this.$store.getters['preferences'] || {} },
    sheets () { return this.$store.getters['sheets/list'] },
    vtable () { return this.prefs[PREF_VTABLE_ID] }
  },
  methods: {
    changeLocale (newLocale) {
      this.locale = newLocale || DEFAULT_LOCALE
      this.$i18n.locale = this.locale
      this.$store.dispatch('changeLocale', this.locale)
      saveLocale(this.locale)
    },
    async copyToClipboard () {
      await copyToClipboard(this.vtable)
      this.showNotifications = true
      setTimeout(() => { this.showNotifications = false }, 5000)
    },
    async diceRolled (diceResult) {
      await this.$store.dispatch('sendDiceResult', { vTable: this.vtable, diceResult })
      await this.refreshHistory()
    },
    async refreshHistory () {
      if (!this.vtable) return
      this.isLoadingHistory = true
      try {
        await this.$store.dispatch('history/list', this.vtable)
      } catch (error) {
        this.error = JSON.stringify(error, undefined, 2)
      }
      setTimeout(() => { this.isLoadingHistory = false }, 500)
    },
    async refreshMice () {
      if (!this.vtable) return
      this.isLoadingMice = true
      try {
        await this.$store.dispatch('sheets/list', this.vtable)
      } catch (error) {
        this.error = JSON.stringify(error, undefined, 2)
      }
      setTimeout(() => { this.isLoadingMice = false }, 500)
    },
    async removeSheet ({ name }) {
      if (!this.vtable) return
      await this.$store.dispatch('sheets/remove', { tableId: this.vtable, name })
      this.refreshMice()
    }
  },
  created () {
    this.$store.dispatch('loadPreferences')
    if (!this.vtable) {
      this.$store.dispatch('savePreferences', { key: PREF_VTABLE_ID, value: uuidv5('mausritter-colony', uuidv4()) })
      this.$store.dispatch('loadPreferences') // Refresh vtable
    }
  },
  async mounted () {
    this.changeLocale(loadLocale())

    dices3D.initialize('dice-canvas', 400, { debug: true })

    // Prevent losing sheet if user clos the browser's tab
    // window.addEventListener("beforeunload", e => {
    //   let isDirty = false
    //   if (this.isStandaloneApp) {
    //     isDirty = this.$refs['welcome-app'].isDirty()
    //   } else {
    //     // Web application
    //     this.$store.commit('historyAdd', { message: this.$t('Welcome to Mausritter Colony!') })
    //     isDirty = this.$refs['welcome'].isDirty()
    //   }

    //   if (!isDirty) {
    //       return undefined
    //   }

    //   let confirmationMessage = this.$t('If you leave before saving, your changes will be lost.')
    //   let event = e || window.event
    //   event.returnValue = confirmationMessage // Gecko + IE
    //   return confirmationMessage // Gecko + Webkit, Safari, Chrome etc.
    // })
  }
}
</script>
