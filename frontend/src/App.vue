<template>
  <div class="app">
    <router-view></router-view>
  </div>
</template>

<script>
import 'normalize.css'
import {mapActions} from "vuex";

export default {
  data() {
    return {}
  },

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
  font-family: 'Manrope', sans-serif;
  font-size: 16px;
  font-weight: 500;
  color: #fff;
  background-color: $backgroundColor;
  height: 100vh;
}

</style>
