<template>
  <div class="settings-authorization">
    <div class="container-settings">
      <p class="name-action">Настройки авторизации</p>

      <form @submit.prevent>
        <div class="element-form">
          <label for="old-password">Текущий пароль</label>
          <BaseInput :type="'password'" v-model.trim="form.oldPassword" id="old-password"></BaseInput>
        </div>

        <div class="element-form">
          <label for="new-password">Новый пароль</label>
          <BaseInput :type="'password'" v-model.trim="form.newPassword" id="new-password"></BaseInput>
        </div>

        <div class="element-form">
          <label for="repeat-password">Повтор пароля</label>
          <BaseInput :type="'password'" v-model.trim="form.repeatPassword" id="repeat-password"></BaseInput>
        </div>

        <BaseButton @click="changePassword">Сохранить</BaseButton>
      </form>
    </div>
  </div>
</template>

<script>
import {instance} from "@/store";
import {mapMutations} from "vuex";

export default {
  name: "SettingsAuthorization",

  data() {
    return {
      form: {
        oldPassword: '',
        newPassword: '',
        repeatPassword: '',
      },
    }
  },

  methods: {
    ...mapMutations(['setErrors']),

    checkRepeatPassword() {
      return this.form.newPassword !== '' && this.form.repeatPassword !== '' && this.form.newPassword === this.form.repeatPassword;
    },

    changePassword() {
      if (this.checkRepeatPassword()) {
        console.log('fff');
        return instance.post(process.env.VUE_APP_API_URL + 'password/verification', this.form).catch(error => {
          this.setErrors({
            message: [error.response.data.message],
          });
        });
      }

      this.setErrors({
        message: ['Введены неверные данные'],
      });
    },
  },
}
</script>

<style lang="scss" scoped>
.settings-authorization {
  width: 100%;

  .container-settings {
    padding: 40px;

    .name-action {
      font-size: 26px;
    }

    form {
      font-size: 16px;
      margin-top: 40px;

      .element-form {
        margin-bottom: 30px;

        &:nth-of-type(3) {
          margin-bottom: 0;
        }

        .base-input {
          width: 40%;
        }
      }

      .base-button {
        margin-top: 40px;
      }
    }
  }
}
</style>
