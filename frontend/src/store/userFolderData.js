import {instance} from '@/store/index';

export default {
  namespaced: true,

  state: () => ({
    dataFolders: [],
    logins: null,
    selectedFolderId: null,
    showSectionSelectedFolder: false,
    showModalConfirmDelete: false,
    showModalRenameFolder: false,
  }),

  getters: {
    getLogins(state) {
      return state.dataFolders.data.filter(item => item.id === state.selectedFolderId);
    }
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

    async sendRequestRenameFolder({commit, state}, val) {
      await instance.put(process.env.VUE_APP_API_URL + 'user/folder/' + state.selectedFolderId, {
        newName: val,
      }, {
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
        }
      }).then(response => {
        if (response.status === 200) {
          const obj = state.dataFolders.data;

          for (let i = 0; i < obj.length; i++) {
            if (obj[i].id === state.selectedFolderId) {
              return commit('setNameFolderFromList', [i, val]);
            }
          }
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
