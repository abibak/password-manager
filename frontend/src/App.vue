<template>
  <div class="app">
    <router-view></router-view>
  </div>
</template>

<script>
import 'normalize.css';
import {mapActions, mapGetters} from "vuex";
import {instance} from "@/store";
import router from "@/router";

export default {
  mounted() {
    const authToken = localStorage.getItem('authToken')
    this.initConfigInstance();

    if (authToken) {
      this.getUserData();
    } else if (authToken === null || authToken === '') {
      router.push('/login');
    }
  },

  computed: {
    ...mapGetters('auth', {
      getAuthToken: 'getAuthToken',
    }),
  },

  methods: {
    ...mapActions({
      'getUserData': 'auth/getUserData',
    }),

    initConfigInstance() {
      instance.interceptors.request.use((config) => {
        config.headers = {
          'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
        }

        return config;
      }, (error) => {
        console.log(error);
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
