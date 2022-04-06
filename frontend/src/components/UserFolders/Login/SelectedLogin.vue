<template>
  <div class="selected-login" v-if="show" :style="{width: widthValue + '%'}">
    <div class="container-selected-login">
      <BaseCloseModal @click="close"></BaseCloseModal>

      {{currentLogin}}

      <div class="info-login">
        <p class="name-login">
          <span class="short-name">{{ this.currentLogin.name.charAt(0) }}</span>
          {{ this.currentLogin.name }}
        </p>
      </div>

      <div class="icon-actions">
        <div class="icon-control">
          <i class="bi bi-pencil-square"></i>
        </div>

        <div class="icon-control" @click="showSettings = !showSettings">
          <i class="bi bi-three-dots"></i>
        </div>
      </div>

      <div class="list-actions-login">
        <span class="action">Общие</span>
        <span class="action">Файлы</span>
      </div>

      <div class="form-login">
        <form>
          <div class="element-form">
            <label for="name">Название</label>
            <BaseInput id="name" :value="currentLogin.name" disabled></BaseInput>
          </div>

          <div class="element-form">
            <label for="login">Логин</label>
            <BaseInput id="login" :value="currentLogin.login" disabled></BaseInput>
            <i class="bi bi-clipboard"></i>
          </div>

          <div class="element-form">
            <label for="password">Пароль</label>
            <BaseInput id="password" :value="currentLogin.password" disabled></BaseInput>
            <i class="bi bi-clipboard"></i>
          </div>

          <div class="element-form">
            <label for="url">URL</label>
            <BaseInput id="url" :value="currentLogin.url" disabled></BaseInput>
            <i class="bi bi-clipboard"></i>
          </div>

          <div class="element-form">
            <label for="tag">Теги</label>
            <BaseInput id="tag" :value="currentLogin.tag" disabled></BaseInput>
            <i class="bi bi-clipboard"></i>
          </div>

          <div class="element-form">
            <label for="note">Заметка</label>
            <textarea id="note" :value="currentLogin.note" disabled></textarea>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapState} from "vuex";

export default {
  name: "SelectedLogin",

  props: {
    show: {
      type: Boolean,
      required: true,
    },
  },

  data() {
    return {
      currentLogin: '',
      widthValue: 25,
    }
  },

  watch: {
    show() {
      if (this.show) {
        setTimeout(() => {
          return this.widthValue = 60;
        }, 1)
      }
      this.widthValue = 25;
    },

    getDataOpenLogin() {
      this.currentLogin = this.getDataOpenLogin;
    },

    getDataOrgOpenLogin() {
      this.currentLogin = this.getDataOrgOpenLogin;
    }
  },

  computed: {
    ...mapState(['typeFolder']),
    ...mapGetters('userFolder', {
      getDataOpenLogin: 'getDataOpenLogin',
    }),
    ...mapGetters('organizationFolder', {
      getDataOrgOpenLogin: 'getDataOrgOpenLogin',
    }),
  },

  methods: {
    close() {
      this.$emit('close');
    },
  },
}
</script>

<style lang="scss" scoped>
.selected-login {
  transition: width .45s;

  .container-selected-login {
    width: 100%;
    padding: 25px 20px 0 20px;
    position: relative;
    top: 0;

    .info-login {
      .name-login {
        font-size: 22px;
        color: #000;
      }

      .short-name {
        display: inline-block;
        width: 30px;
        height: 30px;
        line-height: 30px;
        padding: 0 5px;
        margin-right: 10px;
        text-transform: uppercase;
        text-align: center;
        color: #fff;
        border-radius: 6px;
        background-color: $backgroundColor;
      }
    }

    .icon-actions, .list-actions-login, .element-form {
      width: 65%;
    }

    .icon-actions {
      display: flex;
      align-items: center;
      justify-content: flex-end;

      i {
        font-size: 22px;
        color: #2683e0;
      }

      .icon-control {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 26px;
        height: 26px;
        padding: 16px;
        margin-left: 8px;
        border-radius: 50%;
        border: 1px solid #2683e0;
        cursor: pointer;
      }
    }

    .list-actions-login {
      font-weight: 400;
      display: inline-block;
      padding-bottom: 10px;
      font-size: 20px;
      color: #000;
      border-bottom: 2px solid rgba(163, 163, 163, .3);

      .action {
        margin-right: 15px;
        padding-bottom: 8px;
        cursor: pointer;

        &:hover {
          background-color: #fff;
        }
      }

      .action:first-child {
        border-bottom: 2px solid $backgroundColor;
      }
    }

    form {
      padding-top: 10px;

      .element-form {
        margin-top: 20px;
        position: relative;

        &:first-child {
          margin-top: 15px;
        }

        #password {
          padding-right: 78px;
        }

        textarea {
          display: block;
          width: 100%;
          max-width: 100%;
          min-width: 20%;
          max-height: 350px;
          min-height: 100px;
          outline: none;
          border: 1px solid $color;
          border-radius: 8px;
          margin-top: 15px;
          padding: 10px;
          font-size: 16px;
          transition: border-color $transTime;
        }

        label {
          font-weight: 400;
          font-size: 16px;
        }

        .base-input {
          width: 100%;
          padding: 5px 0;
          font-size: 16px;
        }

        i {
          position: absolute;
          right: 0;
          bottom: 5px;
          cursor: pointer;
        }

        .bi-eye, .bi-eye-slash {
          padding-right: 56px;
        }
      }
    }
  }
}
</style>
