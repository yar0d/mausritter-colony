import Vue from 'vue'

export default {
  namespaced: true,
  state: {
    current: null,
    tableId: null
  },
  getters: {
    current: state => { return state.current },
    tableId: state => { return state.tableId }
  },
  actions: {
    create ({ commit, state, rootState }, { tableId, data }) {
      return Vue.http.post(`${rootState.config.SERVER_API_URL}/vtables.php?vtable=${tableId}`, { data: JSON.stringify(data) })
        .then((response) => {
          state.tableId = response?.body?.id
          commit('setCurrent', { data })
          return response
        })
        .catch((error) => {
          commit('API_FAILURE', error)
        })
    },
    get ({ commit, state, rootState }, tableId) {
      return Vue.http.get(`${rootState.config.SERVER_API_URL}/vtables.php?vtable=${tableId}`)
        .then((response) => {
          state.tableId = response?.body?.id
          commit('setCurrent', { data: response?.body?.data })
          return response
        })
        .catch((error) => {
          commit('API_FAILURE', error)
        })
    },
    update ({ commit, state, rootState }, { data }) {
      return Vue.http.post(`${rootState.config.SERVER_API_URL}/vtables.php?vtable=${state.tableId}`, { data: JSON.stringify(data) })
        .then((response) => {
          commit('setCurrent', { data })
          return response
        })
        .catch((error) => {
          commit('API_FAILURE', error)
        })
    }
  },
  mutations: {
    API_FAILURE: (error) => {
      throw error
    },
    setCurrent (state, { data }) {
      try {
        state.current = JSON.parse(data)
      } catch (error) {
        state.current = null
      }
    }
  }
}
