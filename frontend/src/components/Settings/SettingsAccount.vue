<template>
  <div class="settings-account">
    <div class="container-settings-account">
      <p class="my-account">Мой аккаунт</p>

      <form id="settings-account-form" @submit.prevent enctype="multipart/form-data">
        <div class="block-avatar">
          <label for="avatar">
            <div class="img-avatar"><span>A</span></div>
            <span class="text-add">Добавить аватар</span>
          </label>
          <input ref="avatar-input" type="file" class="input-avatar" id="avatar" name="avatar" hidden>
        </div>

        <div class="block-personal">
          <div class="element-form">
            <label for="login">Логин</label>
            <BaseInput id="login" v-model.trim="form.login" :value="form.login"></BaseInput>
          </div>

          <div class="element-form">
            <label for="email">Email</label>
            <BaseInput id="email" v-model.trim="form.email" :value="form.email"></BaseInput>
          </div>
        </div>

        <div class="checkboxes-settings">
          <div class="element-form">
            <BaseToggle @click="form.emailNotification = !form.emailNotification"
                        v-model:active="form.emailNotification"></BaseToggle>
            <span class="text-checkbox">Отключить email оповещения, при изменениях паролей</span>
          </div>

          <div class="element-form">
            <BaseToggle @click="form.autoLogout = !form.autoLogout" v-model:active="form.autoLogout"></BaseToggle>
            <span class="text-checkbox">Автовыход после 10 минут неактивности</span>
          </div>
        </div>

        <BaseButton @click="sendData">Сохранить</BaseButton>
      </form>
    </div>
  </div>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
  name: "SettingsAccount",

  data() {
    return {
      form: {
        login: '',
        email: '',
        emailNotification: false,
        autoLogout: true,
        avatar: null,
      }
    }
  },

  created() {
    this.initData();
  },

  computed: {
    ...mapState('auth', ['userData']),
  },

  methods: {
    ...mapActions('account', ['sendRequestUpdateSettingsAccount']),

    initData() {
      this.form.login = this.userData.login;
      this.form.email = this.userData.email;

      this.form.emailNotification = Boolean(this.userData.settings[0]['email_notification']);
      this.form.autoLogout = Boolean(this.userData.settings[0]['auto_logout']);
    },

    sendData() {
      this.sendRequestUpdateSettingsAccount(this.form);
    },
  }
}
</script>

<style lang="scss" scoped>
.settings-account {
  padding: 40px 0 0 40px;

  .container-settings-account {
    width: 50%;

    .my-account {
      font-size: 26px;
      color: #000;
    }

    form {
      .base-button {
        margin-top: 40px;
      }

      .block-avatar {
        display: inline-block;
        margin-top: 40px;

        label:first-child {
          display: flex;
          align-items: center;
          cursor: pointer;

          .img-avatar {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background-color: $color;

            span:first-child {
              color: #fff;
              font-size: 20px;
            }
          }

          .text-add {
            padding-left: 10px;
            font-size: 16px;
          }
        }
      }

      .block-personal {
        margin-top: 20px;

        .element-form {
          margin-bottom: 30px;

          label {
            font-size: 16px;
          }

          .base-input {
            width: 80%;
            line-height: 40px;
            font-size: 16px;
          }
        }
      }

      .checkboxes-settings {
        margin-top: 20px;

        .element-form {
          display: flex;
          align-items: center;
          margin-bottom: 20px;

          .text-checkbox {
            font-size: 16px;
            padding-left: 10px;
          }
        }
      }
    }
  }
}
</style>
