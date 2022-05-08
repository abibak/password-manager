<template>
  <transition name="animation-settings-login">
    <div class="settings-login" v-if="show" @click="closeSettings">
      <div class="container-settings">
        <p>Настройки пароля</p>

        <div class="list-settings">
          <div class="action" @click.stop="closeSettings">
            <i class="bi bi-pencil-square"></i>
            <span>История</span>
          </div>

          <div class="action" @click.stop="sendRequestDeleteLogin(), closeSettings()">
            <i class="bi bi-trash3"></i>
            <span class="delete-folder">Удалить</span>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import {mapActions, mapMutations} from "vuex";

export default {
  name: "SettingsLogin",

  props: {
    show: {
      type: Boolean,
      required: true,
    }
  },

  methods: {
    ...mapActions('login', ['sendRequestDeleteLogin']),
    ...mapMutations('login', ['setShowSettingsLogin']),

    closeSettings() {
      this.setShowSettingsLogin(false);
    },
  },
}
</script>

<style lang="scss" scoped>
.animation-settings-login-enter-active, .animation-settings-login-leave-active {
  opacity: 0;
  transition: all $transTime;
}

.animation-settings-login-enter-from {
  transform: scale(.95);
}

.animation-settings-login-enter-to {
  opacity: 1;
  transform: scale(1);
}

.animation-settings-login-leave-to {
  opacity: 0;
  transform: scale(.95);
}

.settings-login {
  background-color: #fff;
  color: #000;
  z-index: 11;
  box-shadow: 0 0 6px 1px #a3a3a3;
  border-radius: 10px;
  position: absolute;
  top: 40px;
  right: 0;

  .container-settings {
    padding: 15px;

    p:first-child {
      white-space: nowrap;
      font-size: 20px;
    }

    .list-settings {
      margin-top: 8px;

      .action {
        display: flex;
        align-items: center;
        margin-top: 5px;
        font-size: 16px;

        &:first-child {
          margin-top: 0;
        }

        &:hover span {
          color: #a3a3a3;
        }

        &:hover:last-child span {
          color: #DB1F1F;
          opacity: .6;
        }

        .delete-folder {
          color: #DB1F1F;
        }

        i {
          padding-right: 10px;
          font-size: 24px;
        }
      }
    }
  }
}
</style>
