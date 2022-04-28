<template>
  <div class="left-settings-menu">
    <div class="container-settings-menu">
      <div class="icon-control" @click="setOpenGeneralSettings(false)">
        <i class="bi bi-arrow-left"></i>
        <span>Назад к папкам</span>
      </div>

      <div class="list-settings">
        <div class="account">
          <p class="header-settings">Мой аккаунт</p>

          <ul>
            <li>Настройки аккаунта</li>
            <li>Авторизация</li>
          </ul>
        </div>

        <div class="management">
          <p class="header-settings">Управление</p>

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
import {mapMutations} from "vuex";

export default {
  name: "LeftSettingsMenu",

  methods: {
    ...mapMutations({
      setOpenGeneralSettings: 'setOpenGeneralSettings',
    }),
  },
}
</script>

<style lang="scss" scoped>
.left-settings-menu {
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
