import Vue from 'vue'

export default {
  namespaced: true,
  state: {
    list: []
  },
  getters: {
    list: state => { return state.list }
  },
  actions: {
    list ({ commit, rootState }, tableId) {
      return Vue.http.get(`${rootState.config.SERVER_API_URL}/sheets.php?vtable=${tableId}`)
        .then((response) => {
          commit('setList', { data: response.data })
          return response
        })
        .catch((error) => {
          commit('FAILURE', error)
        })
    },
    remove ({ commit, rootState }, { tableId, name }) {
      return Vue.http.delete(`${rootState.config.SERVER_API_URL}/sheets.php?vtable=${tableId}&name=${name}`)
        .then((response) => {
          return response
        })
        .catch((error) => {
          commit('FAILURE', error)
        })
    }
  },
  mutations: {
    FAILURE: (error) => {
      throw error
    },
    setList (state, { data }) {
      data.forEach(sheet => {
        sheet.updated = new Date(sheet.updated)
      });
      state.list = data
    }
  }
}
