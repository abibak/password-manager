<template>

  <div class="app">
    <router-view></router-view>
  </div>

</template>

<script>

import 'normalize.css'
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
  background-color: #2683E0;
  height: 100vh;
}

</style>
