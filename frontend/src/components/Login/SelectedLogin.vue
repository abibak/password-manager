<template>
  <div class="selected-login" v-if="show" :style="{opacity: opacity}">
    <BaseModal v-model:show="showEditLogin">
      <EditLoginForm></EditLoginForm>
    </BaseModal>

    <div class="container-selected-login">
      <BaseCloseModal @click="closeBaseModal"></BaseCloseModal>

      <div class="info-login">
        <p class="name-login">
          <span class="short-name">{{ currentLogin.name.charAt(0) }}</span>
          {{ currentLogin.name }}
          <i class="bi bi-star"
             @click="sendRequestAddPasswordFavorite(currentLogin.id)"></i>

          <i class="bi bi-star-fill" v-if="currentLogin.is_favorite === true"
             @click="sendRequestAddPasswordFavorite(currentLogin.id)"></i>
        </p>
      </div>

      <div class="icon-actions">
        <div class="icon-control" @click="setShowEditLogin(true)">
          <i class="bi bi-pencil-square"></i>
        </div>

        <div class="icon-control settings-login-control"
             v-if="userAccess === 3"
             @click="showSettingsLogin = !showSettingsLogin">
          <i class="bi bi-three-dots"></i>

          <!--    Настройки пароля      -->
          <SettingsLogin @closeSettingsLogin="showSettingsLogin = false" v-model:show="showSettingsLogin"></SettingsLogin>
        </div>
      </div>

      <div class="list-actions-login">
        <span class="action" @click="openTab" v-bind:class="general.class" data-action="general">Общие</span>
        <span class="action" @click="openTab"
              v-if="typeFolder === 'orgFolder' && userAccess === 3"
              v-bind:class="historyPassword.class" data-action="history">История действий
        </span>
        <span class="action" @click="openTab" v-bind:class="files.class" data-action="files">Файлы</span>
      </div>

      <ListHistories v-if="userAccess === 3"
                     :history="currentLogin.histories"
                     :show="historyPassword.active && typeFolder === 'orgFolder'">
      </ListHistories>

      <div class="form-login" v-show="general.active">
        <form>
          <div class="element-form">
            <label for="name">Название</label>
            <BaseInput id="name" :value="currentLogin.name" disabled></BaseInput>
          </div>

          <div class="element-form">
            <label for="login">Логин</label>
            <BaseInput id="login" :value="currentLogin.login" disabled></BaseInput>
            <BaseClipboard :value="currentLogin.login"></BaseClipboard>
          </div>

          <div class="element-form">
            <label for="password">Пароль</label>
            <BaseInput id="password" :value="currentLogin.password" disabled></BaseInput>
            <BaseClipboard :value="currentLogin.password"></BaseClipboard>
          </div>

          <div class="element-form">
            <label for="url">URL</label>
            <BaseInput id="url" :value="currentLogin.url" disabled></BaseInput>
            <BaseClipboard :value="currentLogin.url"></BaseClipboard>
          </div>

          <div class="element-form">
            <label for="tag">Теги</label>
            <BaseInput id="tag" :value="currentLogin.tags" disabled></BaseInput>
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
import {mapActions, mapGetters, mapMutations, mapState} from "vuex";
import SettingsLogin from "@/components/Login/SettingsLogin";
import EditLoginForm from "@/components/Login/EditLoginForm";
import ListHistories from "@/components/Login/ListHistories";
import BaseClipboard from "@/components/BaseClipboard";

export default {
  name: "SelectedLogin",
  components: {
    SettingsLogin,
    EditLoginForm,
    ListHistories,
    BaseClipboard,
  },

  props: {
    show: {
      type: Boolean,
      required: true,
    },
  },

  data() {
    return {
      general: {
        active: true,
        class: 'active-tab',
      },

      historyPassword: {
        active: false,
        class: '',
      },

      files: {
        active: false,
        class: '',
      },

      currentLogin: '',
      opacity: 0,
      showSettingsLogin: false,
    }
  },

  watch: {
    show() {
      if (this.show) {
        setTimeout(() => {
          this.opacity = 1;
        }, 1)
      }
      this.opacity = 0;
    },

    // подгрузить папки пользователи или организации
    getDataOpenLogin() {
      if (this.typeFolder === 'userFolder') {
        this.currentLogin = this.getDataOpenLogin;
      } else {
        this.currentLogin = this.getDataOrgOpenLogin;
      }
    },

    getDataOrgOpenLogin() {
      if (this.typeFolder === 'orgFolder') {
        this.currentLogin = this.getDataOrgOpenLogin;
      } else {
        this.currentLogin = this.getDataOpenLogin;
      }
    },
  },

  computed: {
    ...mapState('login', ['showHeadLines', 'showEditLogin']),
    ...mapState('folder', ['typeFolder']),
    ...mapState('organizationFolder', ['userAccess']),
    ...mapGetters('folder', ['getDataOpenLogin', 'getDataOrgOpenLogin']),
  },

  methods: {
    ...mapActions('login', ['sendRequestAddPasswordFavorite']),
    ...mapMutations('login', ['setShowSettingsLogin', 'setShowHeadLines', 'setShowEditLogin']),

    openTab(el) {
      const tab = el.target.getAttribute('data-action');
      this.general.class = '';
      this.historyPassword.class = '';
      this.files.class = '';

      switch (tab) {
        case 'general':
          this.general.active = true;
          this.general.class = 'active-tab'

          this.historyPassword.active = false;
          this.files.active = false;
          break;
        case 'history':
          this.historyPassword.active = true;
          this.historyPassword.class = 'active-tab';

          this.general.active = false;
          this.files.active = false;
          break;
        case 'files':
          this.files.active = true;
          this.files.class = 'active-tab';

          this.general.active = false;
          this.historyPassword.active = false;
          break;
      }
    },

    closeBaseModal() {
      this.opacity = 0;
      this.showSettingsLogin = false;

      setTimeout(() => {
        this.setShowHeadLines(true);
        this.$emit('close');
      }, 300);
    },
  },
}
</script>

<style lang="scss" scoped>
.active-tab {
  border-bottom-color: $baseColor!important;
  transition: border-bottom-color $transTime;
}

.selected-login {
  width: 75%;
  z-index: 1;
  transition: opacity .45s;

  .container-selected-login {
    width: 100%;
    padding: 25px 20px 20px 20px;
    position: relative;
    top: 0;

    .info-login {
      .name-login {
        max-width: 65%;
        font-size: 22px;
        color: #000;
        line-height: 35px;
        word-break: break-all;

        .bi-star, .bi-star-fill {
          padding-left: 6px;

          &:hover {
            color: #ffd93e;
            cursor: pointer;
          }
        }

        .bi-star-fill {
          color: #ffd93e;
        }
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
        background-color: $baseColor;
      }
    }

    .list-actions-login, .element-form, .icon-actions  {
      width: 75%;
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

      .settings-login-control {
        position: relative;
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
        margin-right: 20px;
        padding-bottom: 8px;
        cursor: pointer;
        border-bottom: 2px solid transparent;
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
