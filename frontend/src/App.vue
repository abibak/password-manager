<template>
  <div class="app">
    <router-view></router-view>
  </div>
</template>

<script>
import 'normalize.css'
import {mapActions} from "vuex";

export default {
  mounted() {
    if (localStorage.getItem('authToken')) {
      this.getUserData();
    }
  },

  methods: {
    ...mapActions({
      'getUserData': 'auth/getUserData',
    }),
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
