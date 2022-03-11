<template>
  <div class="site-login">

    <p class="app-name">Password Manager</p>

    <div class="container-login">

      <form class="form-login" @submit.prevent>

        <div class="element-form">
          <label for="email">Адрес Email</label>
          <LoginInput :type-input="form.types.email" v-model.trim="form.login" class="input-login" id="email"/>
        </div>


        <div class="element-form">
          <label for="master-password">Мастер-пароль</label>
          <LoginInput :type-input="form.types.password" v-model.trim="form.password" class="input-login" id="master-password"/>
        </div>

        <BaseButton>Войти</BaseButton>
      </form>
    </div>

  </div>

</template>

<script>
import LoginInput from "@/components/LoginPage/LoginInput";

export default {
  name: "Login",

  components: {
    LoginInput
  },

  data() {
    return {

      form: {
        types: {
          email: 'email',
          password: 'password',
        },

        login: '',
        password: '',
      },
    }
  }
}
</script>

<style scoped>
.app-name {
  font-size: 42px;
  text-align: center;
}

.site-login {
  width: 100%;
  padding-top: 60px;
  background-color: #2683E0;
}

.container-login {
  display: flex;
  justify-content: center;
}

.form-login {
  width: 480px;
  margin: 40px auto;
  padding: 25px;
  background-color: #4EA1F4;
  border-radius: 10px;
}

.form-login .element-form {
  display: flex;
  flex-direction: column;
  padding-top: 25px;
}

.form-login .input-login {
  margin-top: 8px;
}

.form-login .element-form:first-child {
  padding-top: 0;
}

.form-login .base-button {
  margin-top: 40px;
}

</style>
