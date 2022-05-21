<template>
  <div class="app">
    <router-view></router-view>
  </div>
</template>

<script>
import 'normalize.css';
import {mapActions, mapGetters, mapState} from "vuex";
import {instance} from "@/store";

export default {
  created() {
    const authToken = localStorage.getItem('authToken')

    this.initConfigInstance();

    if (authToken) {
      this.getUserData();
    }
  },

  computed: {
    ...mapState('auth', ['isAuth']),
    ...mapGetters('auth', ['getAuthToken']),
  },

  methods: {
    ...mapActions('auth', ['getUserData']),

    initConfigInstance() {
      instance.interceptors.request.use((config) => {
        config.headers = {
          'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
        }

        return config;
      }, (error) => {
        //
      });
    }
  },
}
</script>

<style lang="scss">
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

#app {
  height: 100vh;
  font-family: 'Manrope', sans-serif;
  font-size: 16px;
  font-weight: 500;
  color: #fff;
  overflow-x: hidden;
  background-color: $baseColor;
}

.error-message {
  color: red;
  font-size: 14px;
  position: absolute;
  bottom: -20px;
  left: 0;
}

.name-action {
  font-size: 22px;
  color: #000;
}
</style>
