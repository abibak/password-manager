<template>
  <div class="login-item" @click="selectLogin()" :style="loginItemStyles">
    <p>
      <span class="short-name">{{ login.name[0] }}</span>
      {{ login.name }}
    </p>
    <p class="attribute-login" v-if="showAttributes">{{ login.login }}</p>
    <p class="attribute-login" v-if="showAttributes">{{ login.url }}</p>
    <p class="attribute-login tags" v-if="showAttributes">
      {{login.tags}}
    </p>
  </div>
</template>

<script>
import {mapActions, mapMutations, mapState} from "vuex";

export default {
  name: "LoginItem",

  props: {
    login: {
      type: Object,
      required: true,
    },

    showAttributes: {
      type: Boolean,
      required: true,
    },
  },

  data() {
    return {
      loginItemStyles: {
        backgroundColor: '',
      }
    }
  },

  computed: {
    ...mapState('folder', ['typeFolder', 'selectedLoginId']),
  },

  watch: {
    selectedLoginId() {
      this.test();
    },
  },

  methods: {
    ...mapMutations(['setShowSectionSelectedFolder']),
    ...mapMutations('folder', [
      'setSelectedLoginId',
      'setSelectedOrgLoginId',
      'setSelectedOrgFolderId',
      'setSelectedFolderId'
    ]),
    // login namespace
    ...mapActions('login', ['sendRequestPasswordEvent']),
    ...mapMutations('login', ['setShowSelectedLogin']),

    test() {
      this.loginItemStyles.backgroundColor = '';
    },

    setActiveBackground() {
      this.loginItemStyles.backgroundColor = 'rgba(38, 131, 224, .080)';
    },

    selectLogin() {
      this.setShowSectionSelectedFolder(true);

      if (this.typeFolder === 'orgFolder') {
        this.setSelectedOrgFolderId(this.login.organization_folder_id);

        this.sendRequestPasswordEvent({
          login_id: this.login.id,
          action: 'Открыл пароль',
        });

        this.setSelectedOrgLoginId(this.login.id);
      } else {
        this.setSelectedFolderId(this.login.user_folder_id);
        this.setSelectedLoginId(this.login.id);
      }

      this.setShowSelectedLogin(true);
      this.setActiveBackground();
    },
  },
}
</script>

<style lang="scss" scoped>
.login-item {
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 5px 0;
  margin-top: 5px;
  border-radius: 6px;
  color: #a3a3a3;
  font-weight: 400;
  cursor: pointer;
  transition: background-color .18s;
  position: relative;

  &:first-child {
    margin-top: 0;
  }

  &:hover {
    background-color: rgba(38, 131, 224, .080);
  }

  .attribute-login {
    transition: opacity $transTime;
  }

  p {
    width: 100%;
    margin-right: 15px;
    word-break: break-all;
  }

  p:first-child {
    display: flex;
    align-items: center;

    .short-name {
      display: inline-block;
      width: 25px;
      height: 25px;
      line-height: 25px;
      padding: 0 5px;
      margin-right: 10px;
      text-transform: uppercase;
      text-align: center;
      color: #fff;
      border-radius: 6px;
      background-color: $baseColor;
    }
  }
}
</style>
