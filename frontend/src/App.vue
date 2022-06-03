<template>
  <div class="app">
    <BaseNotification @closeBaseNotification="errorNotification = false" :show="errorNotification">
    </BaseNotification>

    <router-view></router-view>
  </div>
</template>

<script>
import 'normalize.css';
import {mapActions, mapGetters, mapMutations, mapState} from "vuex";
import {instance} from "@/store";

export default {
  data() {
    return {
      errorNotification: false,
    }
  },

  created() {
    const authToken = localStorage.getItem('authToken');
    this.initConfigInstance();

    if (authToken) {
      this.getUserData();
      window.addEventListener('mousemove', this.mouseEventMove);
      this.setLastTimeActive(new Date().getTime());

      let checkSession = setInterval(() => {
        this.checkTimeSession();

        if (!this.isActive || this.userData.settings[0].auto_logout === false) {
          clearInterval(checkSession);
        }
      }, 1000); // one sec
    }
  },

  computed: {
    ...mapState(['errors']),
    ...mapState('auth', ['userData', 'isAuth', 'timeout', 'isActive', 'lastTimeActive']),
    ...mapGetters('auth', ['getAuthToken', 'getAuthSettings']),
  },

  watch: {
    errors() {
      if (this.errors !== null) {
        this.errorNotification = true;
      }
    },
  },

  methods: {
    ...mapActions('auth', ['getUserData', 'logout']),
    ...mapMutations('auth', ['setIsActive', 'setLastTimeActive']),

    initConfigInstance() {
      instance.interceptors.request.use((config) => {
        config.headers = {
          'Authorization': 'Bearer ' + localStorage.getItem('authToken'),
        }

        return config;
      });
    },

    checkTimeSession() {
      if (new Date().getTime() - this.lastTimeActive > this.timeout) {
        this.setIsActive(false);
        this.deactivateSession();
      }
    },

    mouseEventMove() {
      this.setLastTimeActive(new Date().getTime())
    },

    deactivateSession() {
      this.logout();
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
