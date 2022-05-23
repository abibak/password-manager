
export default {
  namespaced: true,

  state: () => ({
    showSettingsAccount: false,
    showSettingsAuthorization: false,
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
    },

    setShowSettingsAuthorization(state, val) {
      state.showSettingsAuthorization = val;
    },
  },

  actions: {
    openSettings({state, commit}) {
      switch (state.selectedSetting) {
        case 'SettingsAccount':
          commit('setShowSettingsAccount', true);
          break;

        case 'SettingsManageUsers':
          commit('setShowSettingsManageUsers', true);
          break;

        case 'SettingsAuthorization':
          commit('setShowSettingsAuthorization', true);
          break;
      }
    },

    closeSettings({state, commit}) {

     /* const ucFirst = state.selectedSetting.charAt(0).toUpperCase();

      console.log(ucFirst);

      let setting = state.selectedSetting.slice(1, state.selectedSetting.length);

      console.log(setting);*/

      switch (state.selectedSetting) {
        case 'SettingsAccount':
          commit('setShowSettingsAccount', false);
          break;

        case 'SettingsManageUsers':
          commit('setShowSettingsManageUsers', false);
          break;

        case 'SettingsAuthorization':
          commit('setShowSettingsAuthorization', false);
          break;
      }
    },
  },
}
