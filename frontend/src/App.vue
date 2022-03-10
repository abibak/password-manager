<template>

  <div class="app">
    <router-view></router-view>
  </div>

</template>

<script>

import axios from 'axios';
import {mapGetters, mapState} from "vuex";

export default {
  data() {
    return {}
  },

  mounted() {
    this.login();
  },

  computed: {
    ...mapState([
      'userData',
      'isAdmin',
      'isBlocked',
    ]),

    ...mapGetters([
      'getFolderById',
    ])
  },

  methods: {
    getFolder() {
      console.log(process.env.VUE_APP_API_URL);
      return this.getFolderById(2);
    },

    login() {
      /*try {
        axios.post('/api/login', {
          'email': '0y4peKfV@mail.ru',
        }).then((response) => {
          console.log(
            'Your name: ' + this.userData.name,
            '\nyour status admin: ' + this.isAdmin,
            '\nsystem blocked: ' + this.isBlocked
          );

          console.log('your folder id:', this.getFolder().name);

          if (this.isBlocked) {
            console.log('Your account blocked, account actions not accessible');
          }
        });
      } catch (e) {
        console.log(e);
      }*/
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
