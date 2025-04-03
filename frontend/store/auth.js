export const state = () => ({
  token: null,
  user: null
})

export const mutations = {
  SET_TOKEN(state, token) {
    state.token = token
  },
  SET_USER(state, user) {
    state.user = user
  }
}

export const actions = {
  async login({ commit }, credentials) {
    try {
      const { data } = await this.$axios.post('/api/login', credentials)
      commit('SET_TOKEN', data.token)
      commit('SET_USER', data.user)
      return data
    } catch (error) {
      throw error
    }
  },

  async logout({ commit }) {
    commit('SET_TOKEN', null)
    commit('SET_USER', null)
  }
} 