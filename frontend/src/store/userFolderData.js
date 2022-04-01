import {instance} from '@/store/index';

export default {
  namespaced: true,

  state: () => ({
    dataFolders: [],
    selectedFolderId: null,
    selectedLoginId: null,
    showSectionSelectedFolder: false,
    showModalConfirmDelete: false,
    showModalRenameFolder: false,
    showModalAddingPassword: false,
  }),

  getters: {
    getLogins(state) {
      return state.dataFolders.data.filter(folder => folder.id === state.selectedFolderId);
    },

    getDataOpenLogin(state) {
      const folder = state.dataFolders.data;

      for (let i = 0; i < folder.length; i++) {
        if (folder[i].id === state.selectedFolderId) {
          return folder[i].logins.filter(login => login.id === state.selectedLoginId)[0];
        }
      }
    },
  },

  mutations: {
    setDataFolders(state, data) {
      state.dataFolders = data;
    },

    setDataLogins(state, data) {
      state.logins = data;
    },

    setSelectedFolderId(state, id) {
      state.selectedFolderId = id;
    },

    setSelectedLoginId(state, val) {
      state.selectedLoginId = val;
    },

    setShowSectionSelectedFolder(state, val) {
      state.showSectionSelectedFolder = val;
    },

    setShowModalConfirmDelete(state, val) {
      state.showModalConfirmDelete = val;
    },

    setShowModalRenameFolder(state, val) {
      state.showModalRenameFolder = val;
    },

    setNameFolderFromList(state, values) {
      state.dataFolders.data[values[0]].name = values[1];
    },

    setShowModalAddingPassword(state, val) {
      state.showModalAddingPassword = val;
    },

    setPasswordInDataFolder(state, values) {
      state.dataFolders.data[values.id].logins.push(values.login);
    },
  },

  actions: {
    async sendRequestGetFolders({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/folder', {
        headers: {'Authorization': 'Bearer ' + localStorage.getItem('authToken')}
      }).then(response => {
        commit('setDataFolders', response.data);
      });
    },

    async sendRequestGetLogins({state, commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/login/' + state.selectedFolderId, {
        headers: {'Authorization': 'Bearer ' + localStorage.getItem('authToken')}
      }).then(response => {
        commit('setDataLogins', response.data.data);
      });
    },

    async sendRequestCreatePassword({state, dispatch, commit}, data) {
      await instance.post(process.env.VUE_APP_API_URL + 'user/login', {
        user_folder_id: state.selectedFolderId,
        name: data.name,
        login: data.login,
        password: data.password,
        url: data.url,
        note: data.note,
        tag: data.tags,
      }, {
        headers: {'Authorization': 'Bearer ' + localStorage.getItem('authToken'),}
      }).then(response => {
        if (response.status === 201) {
          dispatch('searchFolderById').then(data => {
            return commit('setPasswordInDataFolder', {
              id: data,
              login: response.data.data[0],
            });
          });
        }
      }).catch(error => {
        console.log(error.response);
      })
    },

    searchFolderById({state}) {
      const obj = state.dataFolders.data;

      /* поиск папки */
      for (let i = 0; i < obj.length; i++) {
        if (obj[i].id === state.selectedFolderId) {
          return i; // идентификатор по списку объектов dataFolder
        }
      }
    },

    async sendRequestCreateFolder({dispatch}, nameFolder) {
      await instance.post(process.env.VUE_APP_API_URL + 'user/folder', {
        name: nameFolder,
      }, {
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
        }
      }).then(response => {
        if (response.status === 201) {
          dispatch('sendRequestGetFolders');
        }
      });
    },

    async sendRequestRenameFolder({state, dispatch, commit}, val) {
      await instance.put(process.env.VUE_APP_API_URL + 'user/folder/' + state.selectedFolderId, {
        newName: val,
      }, {
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
        }
      }).then(response => {
        if (response.status === 200) {
          dispatch('searchFolderById').then(data => {
            return commit('setNameFolderFromList', [data, val])
          });
        }
      });
    },

    async sendRequestDeleteFolder({state, commit, dispatch}) {
      await instance.delete(process.env.VUE_APP_API_URL + 'user/folder/' + state.selectedFolderId, {
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
        },
      }).then(() => {
        commit('setShowSectionSelectedFolder', false);
        dispatch('sendRequestGetFolders');
      });
    }
  },
}
