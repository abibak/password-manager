<template>
  <div class="left-settings-menu" :style="slideSettingsStyles">
    <div class="container-settings-menu">
      <div class="icon-control" @click="back()">
        <i class="bi bi-arrow-left"></i>
        <span>Назад к папкам</span>
      </div>

      <div class="list-settings">
        <div class="account">
          <p class="header-settings">Мой аккаунт</p>

          <ul>
            <li @click="settingsClickEvent('SettingsAccount')">Настройки аккаунта</li>
            <li @click="settingsClickEvent('SettingsAuthorization')">Авторизация</li>
          </ul>
        </div>

        <div class="management" v-if="userData.is_admin">
          <p class="header-settings">Управление</p>

          <ul>
            <li @click="settingsClickEvent('SettingsManageUsers')">Управление пользователями</li>
            <li @click="settingsClickEvent">Информация об организации</li>
            <li @click="settingsClickEvent">Настройки системы</li>
            <li @click="settingsClickEvent">Панель безопасности</li>
            <li @click="settingsClickEvent">История действий</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapMutations, mapState} from "vuex";

export default {
  name: "LeftSettingsMenu",

  data() {
    return {
      slideSettingsStyles: {
        opacity: 1,
        transform: 'translate(0,0)',
      }
    }
  },

  watch: {
    // maybe del
    selectedOrgFolderId() {
      this.back();
    },

    selectedFolderId() {
      this.back();
    }
  },

  computed: {
    ...mapState('folder', ['selectedOrgFolderId', 'selectedFolderId']),
    ...mapState('settings', ['selectedSetting']),
    ...mapState('auth', ['userData']),
  },

  methods: {
    ...mapActions('settings', ['closeSettings', 'openSettings']),
    ...mapMutations(['setOpenGeneralSettings']),
    ...mapMutations('settings', [
      'setShowSettingsAccount',
      'setShowSettingsManageUsers',
      'setSelectedSetting',
      'setShowSettingsAuthorization',
      'setShowSettingsAuthorization',
    ]),

    settingsClickEvent(setting) {
      this.closeSettings();

      this.setSelectedSetting(setting); // установка типа настройки
      this.openSettings(); // открыть установленную настройку
    },

    back() {
      this.slideSettingsStyles.transform = 'translate(-25px, 0)';
      this.slideSettingsStyles.opacity = 0;

      setTimeout(() => {
        this.setOpenGeneralSettings(false)
      }, 280);

      this.closeSettings();
    },
  },
}
</script>

<style lang="scss" scoped>
.left-settings-menu {
  transition: opacity, transform, $transTime;

  .container-settings-menu {
    .icon-control {
      display: flex;
      align-items: center;
      padding-bottom: 10px;
      text-transform: lowercase;
      cursor: pointer;
      border-bottom: 1px solid $color;

      .bi-arrow-left {
        font-size: 20px;
        padding-right: 8px;
      }
    }

    .header-settings {
      padding-bottom: 10px;
      text-transform: uppercase;
    }

    .account {
      margin-right: 80px;
    }

    .account, .management {
      width: 300px;
      margin-top: 20px;
      color: #000;
    }

    ul {
      list-style-type: none;

      li {
        font-weight: 400;
        color: #8f8f8f;
        margin-bottom: 10px;
        border-bottom: 1px solid transparent;
        cursor: pointer;
        -webkit-transition: color $transTime;
        -moz-transition: color $transTime;
        -o-transition: color $transTime;
        transition: color, $transTime;
        position: relative;

        &:hover {
          color: $colorHover;

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

</style>
