import Vue from 'vue'
import Vuex from 'vuex'

import config from '@/config'
import { loadPrefs, savePrefsKey } from '@/services/preferences'
import history from './history'
import sheets from './sheets'
import vtable from './vtable'

Vue.use(Vuex)

export const store = new Vuex.Store({
  modules: {
    history,
    sheets,
    vtable
  },
  state () {
    return {
      config,
      locale: null,
      preferences: {},
      standaloneApp: false // This is true if this app is a computer application. By default this app is a web page
    }
  },
  getters: {
    config: state => { return state.config || {} },
    locale: state => { return state.locale },
    preferences: state => { return state.preferences || {} },
    standaloneApp: state => { return state.standaloneApp }
  },
  mutations: {
    setLocale (state, locale) {
      state.locale = locale
    },
    setSheets (state, sheets) {
      state.sheets = sheets
    },
    setPrefs (state, preferences) {
      state.preferences = preferences
    },
    setStandaloneApp (state, standaloneApp) {
      state.standaloneApp = standaloneApp
    }
  },
  actions: {
    changeLocale (context, locale) {
      context.commit('setLocale', locale)
    },
    loadPreferences (context) {
      context.commit('setPrefs', loadPrefs())
    },
    savePreferences (context, { key, value }) {
      context.commit('setPrefs', savePrefsKey(key, value))
    },
    async sendDiceResult ({ commit }, { vTable, diceResult }) {
      const options = {
        method: 'POST',
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(diceResult)
      }
      return fetch(`${config.SERVER_API_URL}/dices.php?vtable=${vTable}&sheet=${vTable}`, options)
        .then((response) => {
          return response
        })
        .catch((error) => {
          commit('FAILURE', error)
        })
    }
  }
})

export default store
