import {instance} from "@/store/index";

const initialState = () => ({
  dataUserFolders: [],
  dataCurrentSelectedFolder: null,

  selectedFolderId: null,
  selectedLoginId: null,

  dataOrganizationFolders: [],
  selectedOrgFolderId: null,
  selectedOrgLoginId: null,

  typeFolder: null,
})

export default {
  namespaced: true,

  state: initialState(),

  getters: {
    getListFolderLogins(state) {
      return state.dataCurrentSelectedFolder?.logins || [];
    },
  },

  mutations: {
    // сброс состояния до первоначального
    resetState(state) {
      const initial = initialState();

      Object.keys(initial).forEach(key => {
        state[key] = initial[key];
      });
    },

    setFolder(state, folder) {
      state.dataCurrentSelectedFolder = folder;
    },

    // изменение имени папки
    setFolderName(state, name) {
      state.dataCurrentSelectedFolder.name = name;
    },

    setTypeFolder(state, val) {
      state.typeFolder = val;
    },

    setDataUserFolders(state, data) {
      state.dataUserFolders = data;
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
    },

    setShowModalAddingPassword(state, val) {
      state.showModalAddingPassword = val;
    },

    // fix
    // обращаться напрямую к текущей папке, и пушить данные в список паролей
    setPasswordInDataFolder(state, password) {
      state.dataCurrentSelectedFolder.logins.push(password);
    },

    setDataOrganizationFolders(state, data) {
      state.dataOrganizationFolders = data;
    },
  },

  actions: {
    // определение пути для работы с папкой
    defineLink({state}) {
      if (state.typeFolder === 'orgFolder') {
        return 'organization/';
      } else {
        return 'user/';
      }
    },

    // fix
    // old
    /*searchFolderById({state}) {
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
          return i; // индекс массива по списку dataFolder
        }
      }
    },*/

    async sendRequestGetUserFolders({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/folder').then(response => {
        commit('setDataUserFolders', response.data);
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
      }).then(() => {
        dispatch('sendRequestGetFolders');
        dispatch('sendRequestGetOrganizationFolders');
      });
    },

    async sendRequestRenameFolder({state, dispatch, commit}, val) {
      let folderId = (state.typeFolder === 'orgFolder') ? state.selectedOrgFolderId : state.selectedFolderId;

      await instance.put(process.env.VUE_APP_API_URL + await dispatch('defineLink') + 'folder/' + folderId, {
        name: val,
      }).then(response => {
        commit('setFolderName', val);
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
