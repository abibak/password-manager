import {instance} from '@/store/index';

export default {
  namespaced: true,

  state: () => ({
    dataFolders: [],
    logins: null,
    selectedFolderId: null,
    showSectionSelectedFolder: false,
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
    }
  },

  actions: {
    async sendRequestGetFolders({commit}) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/folder', {
        headers: {'Authorization': 'Bearer ' + localStorage.getItem('authToken')}
      }).then(response => {
        commit('setDataFolders', response.data);
      })
    },

    async sendRequestGetLogins({commit}, idFolder) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/login/' + idFolder, {
        headers: {'Authorization': 'Bearer ' + localStorage.getItem('authToken')}
      }).then(response => {
        commit('setDataLogins', response.data.data);
      })
    },

    async sendRequestDeleteFolder({commit}, idFolder) {
      await instance.get(process.env.VUE_APP_API_URL + 'user/folder/' + idFolder, {
        headers: {
          'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
        },
      }).then(response => {
        console.log(response.data + response.status);
      }).catch(error => {
        console.log(error);
      })
    }
  },
}
