
export default {
  namespaced: true,

  state: () => ({
    showSettingsAccount: false,
    showSettingsManageUsers: false,
    selectedSetting: '',
  }),

  getters: {},

  mutations: {
    setSelectedSetting(state, val) {
      state.selectedSetting = val;
    },

    setShowSettingsAccount(state, val) {
      state.showSettingsAccount = val;
    },

    setShowSettingsManageUsers(state, val) {
      state.showSettingsManageUsers = val;
    }
  },

  actions: {
    openSettings({state, commit}) {
      switch (state.selectedSetting) {
        case 'accountSettings':
          commit('setShowSettingsAccount', true);
          break;

        case 'manageUsers':
          commit('setShowSettingsManageUsers', true);
          break;
      }
    },

    closeSettings({state, commit}) {
      switch (state.selectedSetting) {
        case 'accountSettings':
          commit('setShowSettingsAccount', false);
          break;

        case 'manageUsers':
          commit('setShowSettingsManageUsers', false);
          break;
      }
    }
  },
}
