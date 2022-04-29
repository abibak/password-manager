
export default {
  namespaced: true,

  state: () => ({
    showSettingsAccount: false,
    selectedSetting: '',
  }),

  getters: {},

  mutations: {
    setShowSettingsAccount(state, val) {
      state.showSettingsAccount = val;
    },

    setSelectedSetting(state, val) {
      state.selectedSetting = val;
    },
  },

  actions: {},
}
