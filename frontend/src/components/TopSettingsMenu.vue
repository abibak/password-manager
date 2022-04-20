<template>
  <div class="top-menu-settings" :style="{top: top + 'px'}">
    <div class="container-settings">
      <BaseCloseModal @click="setShowTopSettingsMenu(false)"></BaseCloseModal>

      <div class="list-settings">
        <div class="account">
          <p class="header-settings">Мой аккаунт</p>
          <hr>

          <ul>
            <li>Настройки аккаунта</li>
            <li @click="logoutSystem">Выход из системы</li>
          </ul>
        </div>

        <div class="management">
          <p class="header-settings">Управление</p>
          <hr>

          <ul>
            <li>Управление пользователями</li>
            <li>Информация об организации</li>
            <li>Настройки системы</li>
            <li>Настройки системы</li>
            <li>Панель безопасности</li>
            <li>История действий</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapMutations, mapState} from "vuex";
import router from "@/router";

export default {
  name: "TopSettingsMenu",

  data() {
    return {
      top: '-120',
    }
  },

  created() {
    setTimeout(() => {
      this.top = '0';
    }, 50)
  },

  computed: {
    ...mapState(['showTopSettingsMenu']),
  },

  methods: {
    ...mapActions('auth', {
      logout: 'logout',
    }),

    ...mapMutations({
      setShowTopSettingsMenu: 'setShowTopSettingsMenu',
    }),

    logoutSystem() {
      router.push('/login');
      this.setShowTopSettingsMenu(false);
      this.logout();
    },
  }
}
</script>

<style lang="scss" scoped>
.top-menu-settings {
  width: 100%;
  color: #000;
  background-color: #f5f5f5;
  z-index: 2;
  position: absolute;
  transition: top .35s;

  .container-settings {
    padding: 45px 60px;

    .base-close-modal {
      color: $colorRemove;
      z-index: 11;

      &:hover {
        color: #a3a3a3;
      }
    }

    .list-settings {
      width: 100%;
      display: flex;
      font-size: 18px;

      .header-settings {
        padding-bottom: 10px;
        text-transform: uppercase;
      }

      .account {
        margin-right: 80px;
      }

      .account, .management {
        width: 300px;
      }

      ul {
        padding-top: 15px;
        list-style-type: none;

        li {
          font-weight: 400;
          color: #8f8f8f;
          margin-bottom: 12px;
          border-bottom: 1px solid transparent;
          cursor: pointer;
          -webkit-transition: color $transTime;
          -moz-transition: color $transTime;
          -o-transition: color $transTime;
          transition: color, $transTime;
          position: relative;

          &:hover {
            color: $colorHover;
            transform: translate(2%);

            &:before {
              content: "";
              width: 3px;
              height: 100%;
              background-color: $baseColor;
              position: absolute;
              left: -8px;
              border-radius: 8px;
            }
          }
        }
      }
    }

  }
}
</style>
