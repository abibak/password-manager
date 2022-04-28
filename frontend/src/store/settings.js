
export default {
  namespaced: true,

  state: () => ({
    showSettingsAccount: false,
  }),

  getters: {},

  mutations: {
    setShowSettingsAccount(state, val) {
      state.showSettingsAccount = val;
    }
  },

  actions: {},
}
