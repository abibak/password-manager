import {instance} from "@/store/index";

export default {
  namespaced: true,

  state: () => ({
    dataFolders: [],
    selectedFolderId: null,
    selectedLoginId: null,

    dataOrganizationFolders: [],
    selectedOrgFolderId: null,
    selectedOrgLoginId: null,

    typeFolder: null,
  }),

  getters: {
    // optimize
    getLogins(state) {
      return state.dataFolders.data?.filter(folder => folder.id === state.selectedFolderId);
    },
    // optimize
    getOrgLogins(state) {
      return state.dataOrganizationFolders.data?.filter(folder => folder.id === state.selectedOrgFolderId);
    },

    // optimize
    getDataOpenLogin(state) {
      const folder = state.dataFolders.data ?? [];

      for (let i = 0; i < folder.length; i++) {
        if (folder[i].id === state.selectedFolderId) {
          return folder[i].logins.filter(login => login.id === state.selectedLoginId)[0];
        }
      }
    },
    // optimize
    getDataOrgOpenLogin(state) {
      const folder = state.dataOrganizationFolders.data ?? [];

      for (let i = 0; i < folder.length; i++) {
        if (folder[i].id === state.selectedOrgFolderId) {
          return folder[i].logins.filter(login => login.id === state.selectedOrgLoginId)[0];
        }
      }
    },
  },

  mutations: {
    setTypeFolder(state, val) {
      state.typeFolder = val;
    },

    setDataFolders(state, data) {
      state.dataFolders = data;
    },

    setSelectedFolderId(state, id) {
      state.selectedFolderId = id;
    },

    setSelectedLoginId(state, val) {
      state.selectedLoginId = val;
    },

    setSelectedOrgFolderId(state, val) {
      state.selectedOrgFolderId = val;
    },

    setSelectedOrgLoginId(state, val) {
      state.selectedOrgLoginId = val;
    },

    setShowModalRenameFolder(state, val) {
      state.showModalRenameFolder = val;
    },

    changeLoginFavoriteStatus(state, data) {
      console.log('add favorite function');
     /* let folder = null;
      let loginId = null;

      if (state.typeFolder === 'orgFolder') {
        folder = state.dataOrganizationFolders.data[data.index_folder];
        loginId = state.selectedOrgLoginId;
      } else {
        folder = state.dataFolders.data[data.index_folder];
        loginId = state.selectedLoginId;
      }

      for (const login of folder.logins) {
        if (login.id === loginId) {
          login.is_favorite = login.is_favorite !== true;
          break;
        }
      }*/
    },

    // установка имени папки
    setNameFolderFromList(state, values) {
      if (state.typeFolder === 'orgFolder') {
        state.dataOrganizationFolders.data[values[0]].name = values[1];
      } else {
        state.dataFolders.data[values[0]].name = values[1];
      }
    },

    setShowModalAddingPassword(state, val) {
      state.showModalAddingPassword = val;
    },

    // fix
    setPasswordInDataFolder(state, values) {
      if (state.typeFolder === 'orgFolder') {
        state.dataOrganizationFolders.data[values.id].logins.push(values.login);
      } else {
        state.dataFolders.data[values.id].logins.push(values.login);
      }
    },

    setDataOrganizationFolders(state, data) {
      state.dataOrganizationFolders = data;
    },
  },

  actions: {
    // определелить путь для действий
    defineLink({state}) {
      if (state.typeFolder === 'orgFolder') {
        return 'organization/';
      } else {
        return 'user/';
      }
    },

    // fix
    searchFolderById({state}) {
      let obj = '';
      let folderId = 0;

      if (state.typeFolder === 'orgFolder') {
        folderId = state.selectedOrgFolderId;
        obj = state.dataOrganizationFolders.data
      } else {
        folderId = state.selectedFolderId;
        obj = state.dataFolders.data;
      }

      // поиск папки и получение идентификатора
      for (let i = 0; i < obj.length; i++) {
        if (obj[i].id === folderId) {
          return i; // индекс по списку dataFolder
        }
      }
    },

    async sendRequestGetFolders({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/folder').then(response => {
        commit('setDataFolders', response.data);
      });
    },

    async sendRequestGetOrganizationFolders({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'organization/folder').then(response => {
        commit('setDataOrganizationFolders', response.data);
      });
    },

    async sendRequestCreateFolder({state, dispatch}, nameFolder) {
      await instance.post(process.env.VUE_APP_API_URL + await dispatch('defineLink') + 'folder', {
        name: nameFolder,
      }).then(response => {
        console.log(response);
        if (response.status === 201) {
          dispatch('sendRequestGetFolders');
          dispatch('sendRequestGetOrganizationFolders');
        }
      });
    },

    async sendRequestRenameFolder({state, dispatch, commit}, val) {
      let folderId = (state.typeFolder === 'orgFolder') ? state.selectedOrgFolderId : state.selectedFolderId;

      await instance.put(process.env.VUE_APP_API_URL + await dispatch('defineLink') + 'folder/' + folderId, {
        name: val,
      }).then(response => {
        if (response.status === 200) {
          dispatch('searchFolderById').then(data => {
            return commit('setNameFolderFromList', [data, val])
          });
        }
      });
    },

    async sendRequestDeleteFolder({state, commit, dispatch}) {
      let folderId = (state.typeFolder === 'orgFolder') ? state.selectedOrgFolderId : state.selectedFolderId;

      await instance.delete(process.env.VUE_APP_API_URL + await dispatch('defineLink') + 'folder/' + folderId).then(() => {
        commit('setShowSectionSelectedFolder', false, {root: true});
        dispatch('sendRequestGetFolders');
        dispatch('sendRequestGetOrganizationFolders');
      });
    }
  },
}
