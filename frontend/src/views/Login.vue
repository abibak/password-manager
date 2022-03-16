<template>
  <div class="site-login">
    <div class="head-login">
      <i class="fas fa-lock"></i>
      <p class="app-name">Password Manager</p>
    </div>

    <div class="container-login">
      <form class="form-login" @submit.prevent novalidate>

        <div class="element-form">
          <label for="email">Адрес Email</label>
          <LoginInput
            :type-input="form.types[0]"
            v-model.trim="form.details.email"
            class="input-login"
            id="email"/>
          <span class="error" v-if="this.errors.email">{{this.errors.email[0]}}</span>
        </div>

        <div class="element-form">
          <label for="master-password">Мастер-пароль</label>

          <div class="group-login">
            <LoginInput
              :type-input="form.types[1]"
              v-model.trim="form.details.password"
              class="input-login password"
              id="master-password"/>
            <i class="bi bi-eye"></i>
          </div>
          <span class="error" v-if="this.errors.password">{{this.errors.password[0]}}</span>
        </div>

        <BaseButton @click="login">Войти</BaseButton>
      </form>
    </div>
  </div>
</template>

<script>
import LoginInput from "@/components/LoginPage/LoginInput";
import {mapActions, mapState} from "vuex";

export default {
  name: "Login",

  components: {
    LoginInput
  },

  data() {
    return {
      form: {
        types: [
          'text',
          'password',
        ],

        details: {
          email: '',
          password: '',
        }
      },
    }
  },

  computed: {
    ...mapState(['errors']),
  },

  methods: {
    ...mapActions({
      sendLoginRequest: 'auth/sendLoginRequest',
    }),

    login() {
      this.sendLoginRequest(this.form.details);
    },
  },
}
</script>

<style lang="scss" scoped>
.site-login {
  width: 100%;
  padding-top: 60px;

  .head-login {
    display: flex;
    justify-content: center;
    align-items: center;

    .app-name {
      font-size: 46px;
      text-align: center;
    }

    .fa-lock {
      padding-right: 15px;
      text-align: center;
      font-size: 74px;
    }
  }

  .container-login {
    display: flex;
    justify-content: center;

    .error {
      color: red;
      font-size: 14px;
      position: absolute;
      bottom: -20px;
      left: 0;
    }

    .group-login {
      display: flex;
      align-items: center;
    }

    .form-login {
      width: 490px;
      margin: 40px auto;
      padding: 25px;
      background-color: #4EA1F4;
      border-radius: 10px;
    }

    .form-login .element-form {
      display: flex;
      flex-direction: column;
      padding-top: 25px;
      position: relative;

      label {
        margin-bottom: 8px;
      }
    }

    .form-login .input-login {
      width: 100%;
      display: flex;
      padding-top: 8px;
    }

    .form-login .bi-eye {
      padding: 0 10px;
      cursor: pointer;
      font-size: 20px;
      transition: color $transTime;

      &:hover {
        color: #ccc;
      }
    }

    .form-login .element-form:first-child {
      padding-top: 0;
    }

    .form-login .base-button {
      margin-top: 25px;
      transition: background-color $transTime;

      &:hover {
        background-color: rgba(38, 131, 224, .75);
      }
    }
  }
}

</style>
