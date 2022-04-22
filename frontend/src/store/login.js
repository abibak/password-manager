import {instance} from "@/store";
import {defineLink} from "@/store/folder";

export default {
  namespaced: true,

  state: () => ({
    showSettingsLogin: false,
    confirmDeleteLogin: false,
  }),

  getters: {},

  mutations: {
    setShowSettingsLogin(state, val) {
      console.log(val);
      state.showSettingsLogin = val;
    },

    // показать/скрыть подтверждение удаления пароля
    setConfirmDeleteLogin(state, val) {
      state.confirmDeleteLogin = val;
    },
  },

  actions: {
    async sendRequestCreatePassword({state, dispatch, commit}, data) {
      let dataCreatePassword = {
        name: data.name,
        login: data.login,
        password: data.password,
        url: data.url,
        note: data.note,
        tag: data.tags,
      };

      if (state.typeFolder === 'orgFolder') {
        dataCreatePassword.organization_folder_id = state.selectedOrgFolderId;
      } else {
        dataCreatePassword.user_folder_id = state.selectedFolderId;
      }

      await instance.post(process.env.VUE_APP_API_URL + defineLink(state.typeFolder) + 'login', dataCreatePassword).then(response => {
        if (response.status === 201) {
          //  поиск папки для установки пароля
          dispatch('searchFolderById').then(data => {
            return commit('setPasswordInDataFolder', {
              id: data,
              login: response.data.data[0],
            });
          });
        }
      });
    },

    sendRequestDeleteLogin() {
      console.log(defineLink);
    },
  },
}
