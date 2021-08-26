import Vue from 'vue'

export default {
  namespaced: true,
  state: {
    current: null
  },
  getters: {
    current: state => { return state.current }
  },
  actions: {
    create ({ commit, rootState }, tableId) {
      return Vue.http.post(`${rootState.config.SERVER_API_URL}/vtables.php?vtable=${tableId}`)
        .then((response) => {
          return response
        })
        .catch((error) => {
          commit('API_FAILURE', error)
        })
    },
    get ({ commit, rootState }, tableId) {
      return Vue.http.get(`${rootState.config.SERVER_API_URL}/vtables.php?vtable=${tableId}`)
        .then((response) => {
          commit('setCurrent', { data: response.data })
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
      state.current = data
    }
  }
}
