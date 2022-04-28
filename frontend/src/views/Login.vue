<template>
  <div class="site-login">
    <div class="right-background"></div>

    <div class="container-login">
      <div class="left-info-section">
        <img src="../assets/images/logo.png" alt="Logo" class="logo">

        <div class="important-information">
          <p class="important-text">Пожалуйста, <span>внимательно</span> ознакомьтесь с информацией предоставленной
            ниже.</p>

          <ul>
            <li><i class="bi bi-circle-fill"></i>Никому не сообщайте свой пароль</li>
            <li><i class="bi bi-circle-fill"></i>Не используйте пароли повторно</li>
          </ul>
        </div>
      </div>

      <div class="right-form-section">
        <p>Введите свои данные</p>

        <form @submit.prevent>
          <LoginInput :type-input="form.types[0]"
                      v-model="form.details.email"
                      placeholder="Введите e-mail">
          </LoginInput>

          <LoginInput :type-input="form.types[1]"
                      v-model="form.details.password"
                      placeholder="Введите пароль">
          </LoginInput>

          <div class="right-block" @click="login">
            <span>Я не помню свой e-mail или пароль</span>

            <div class="block-btn">
              <div class="icon-arrow">
                <i class="bi bi-arrow-right"></i>
              </div>

              <BaseButton>Продолжить</BaseButton>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapState} from "vuex";
import LoginInput from "@/components/LoginPage/LoginInput";

export default {
  name: "Login",

  components: {
    LoginInput
  },

  data() {
    return {
      form: {
        types: [
          'email',
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
  display: flex;
  justify-content: flex-end;
  width: 100%;
  height: 100vh;
  color: #000;
  background-color: #fff;
  user-select: none;

  .right-background {
    width: 45%;
    height: 100%;
    background: #2683E0;
    box-shadow: 0 4px 20px 5px rgba(0, 0, 0, 0.25);
    border-radius: 90px 0 0 90px;
    position: absolute;
    right: 0;
  }

  .container-login {
    display: flex;
    justify-content: space-around;
    width: 65%;
    margin: 0 auto;

    .left-info-section {
      width: 80%;

      .logo {
        width: 186px;
        height: 40px;
        margin-top: 80px;
        pointer-events: none;
      }

      .important-information {
        width: 50%;
        color: #727272;
        font-size: 20px;
        font-weight: 400;

        position: relative;
        top: 225px;

        .important-text {
          span:first-child {
            font-weight: 500;
          }
        }

        ul {
          padding: 38px 0 0 10px;
          list-style-type: none;
          width: 495px;
          line-height: 38px;
          font-style: normal;
          font-weight: 400;

          li {
            display: flex;
            align-items: center;
            letter-spacing: -0.05em;

            i {
              font-size: 7px;
              padding-right: 8px;
            }
          }
        }
      }
    }

    .right-form-section {
      display: flex;
      flex-direction: column;
      z-index: 1;

      p:first-child {
        font-size: 55px;
        line-height: 100%;
        width: 413px;
        height: 113px;
        color: #fff;
        margin-top: 140px;
      }

      form {
        display: flex;
        flex-direction: column;
        margin-top: 80px;

        .input-login {
          width: 100%;
          height: 56px;
          padding: 0 12px;
          color: $color;
          border-radius: 8px;
          margin-top: 46px;
        }

        .right-block {
          display: flex;
          flex-direction: column;
          align-items: flex-end;
          margin-top: 46px;

          span {
            color: #fff;
            line-height: 22px;
            text-decoration-line: underline;
            cursor: pointer;
          }

          .block-btn {
            display: flex;
            align-items: center;
            width: 190px;
            height: 69px;
            margin-top: 80px;
            background-color: #fff;
            border-radius: 40px;
            position: relative;
            transition: width $transTime;
            cursor: pointer;

            &:active .icon-arrow {
              background-color: $baseColor;
            }

            &:active i {
              color: #fff;
            }

            &:hover .base-button {
              transform: translate(-20%);
            }

            &:hover {
              width: 220px;
            }

            &:hover .icon-arrow {
              opacity: 1;
              right: 10px;
            }

            .icon-arrow {
              display: flex;
              align-items: center;
              justify-content: center;
              width: 50px;
              height: 50px;
              opacity: 0;
              border: 2px solid $baseColor;
              z-index: 11;
              border-radius: 100%;
              position: absolute;
              right: -10px;
              transition: opacity, right, $transTime;
            }

            i {
              color: $baseColor;
              font-size: 28px;
            }

            .base-button {
              width: inherit;
              height: inherit;
              color: $baseColor;
              font-weight: 500;
              padding: 0 20px;
              background-color: transparent;
              position: absolute;
              transition: transform $transTime;
            }
          }
        }
      }
    }
  }
}
</style>
