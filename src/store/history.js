import Vue from 'vue'

export default {
  namespaced: true,
  state: {
    list: []
  },
  getters: {
    list: state => { return state.list || [] }
  },
  actions: {
    clear ({ commit, rootState }, tableId) {
      return Vue.http.delete(`${rootState.config.SERVER_API_URL}/dices.php?vtable=${tableId}`)
        .then((response) => {
          return response
        })
        .catch((error) => {
          commit('API_FAILURE', error)
        })
    },
    list ({ commit, rootState }, tableId) {
      return Vue.http.get(`${rootState.config.SERVER_API_URL}/dices.php?vtable=${tableId}`)
        .then((response) => {
          commit('setList', { data: response.data })
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
    setList (state, { data }) {
      const result = []
      if (data && Array.isArray(data)) {
        data.forEach(line => {
          try {
            result.push({
              ...line,
              _date: new Date(line.timestamp),
              _json: JSON.parse(line.json)
            })
          } catch (error) {
            console.error('[history] json parse error:', error)
            console.error('[history] for:', line)
          }
        })
      }
      state.list = result
      // Sort by date DESC. Latest date start the array
      // state.list = result.sort((a, b) => {
      //   return b._date.getTime() - a._date.getTime()
      // }) || []
    }
  }
}
