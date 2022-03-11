import {createStore} from 'vuex'
import auth from "@/store/auth";

export default createStore({
  state: () => ({
    errors: [],
  }),

  getters: {

  },

  mutations: {

  },

  actions: {

  },

  modules: {
    auth: auth,
  }
})
