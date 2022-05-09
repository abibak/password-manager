<template>
  <div class="list-login" :style="{width: widthValue + '%'}">
    <div class="headlines">
      <div>Название</div>
      <div v-if="showHeadLines">Логин</div>
      <div v-if="showHeadLines">URL</div>
      <div v-if="showHeadLines">Теги</div>
    </div>

    <div class="login">
      <transition-group name="animation-list-login">
        <LoginItem :login="item"
                   :show-attributes="showHeadLines"
                   v-for="(item) of folderData[0].logins"
                   :key="item"
                   @click="openLogin">
        </LoginItem>
      </transition-group>
    </div>
  </div>
</template>

<script>
import LoginItem from "@/components/Folder/Login/LoginItem";
import {mapMutations, mapState} from "vuex";

export default {
  name: "LoginList",
  components: {LoginItem},

  props: {
    folderData: {
      required: true,
    },

    widthValue: {
      type: Number,
    },
  },

  watch: {
    selectedFolderId() {
      this.setShowHeadLines(true);
    },

    selectedOrgFolderId() {
      this.setShowHeadLines(true);
    }
  },

  computed: {
    ...mapState('folder', ['selectedFolderId']),
    ...mapState('organizationFolder', ['selectedOrgFolderId']),
    ...mapState('login', ['showHeadLines']),
  },

  methods: {
    ...mapMutations('login', ['setShowHeadLines']),

    openLogin() {
      this.setShowHeadLines(false);
      this.$emit('openLogin');
    },
  },
}
</script>

<style lang="scss" scoped>
.animation-list-login-enter-active, .animation-list-login-leave-active {
  transition: all $transTime;
}

.animation-list-login-enter-from {
  opacity: 0;
  transform: scale(.98);
}

.animation-list-login-enter-to {
  opacity: 1;
  transform: scale(1);
}

.animation-list-login-leave-from {
  color: transparent;
}

.animation-list-login-leave-to {
  opacity: 0;
  transform: scale(.98);
  position: absolute;
}

.list-login {
  padding: 25px 20px 0 20px;
  border-right: 1px solid #a3a3a3;
  font-size: 16px;
  transition: width .45s;
  position: relative;

  .headlines, .login {
    width: 75%;
  }

  .login {
    width: 100%;
    margin-top: 10px;
  }

  .headlines {
    width: 100%;
    display: flex;
    justify-content: space-between;
    color: #000;
    font-weight: 500;
    text-transform: uppercase;

    div {
      width: 100%;
      text-align: left;
      transition: opacity 2s;
    }
  }
}
</style>
