<template>
  <div class="list-login" :style="{width: widthValue + '%'}">
    <div class="headlines">
      <div>Название</div>
      <div v-if="hideHeadlines">Логин</div>
      <div v-if="hideHeadlines">URL</div>
      <div v-if="hideHeadlines">Теги</div>
    </div>

    <div class="login">
      <LoginItem :login="item" v-model:show-attributes="hideHeadlines" v-for="(item) of folderData[0].logins"
                 :key="item.login_id"
                 @click="openLogin"></LoginItem>
    </div>
  </div>
</template>

<script>
import LoginItem from "@/components/UserFolders/Login/LoginItem";
import {mapState} from "vuex";

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

  data() {
    return {
      hideHeadlines: true,
    }
  },

  watch: {
    selectedFolderId() {
      this.hideHeadlines = true;
    },
    selectedOrgFolderId() {
      this.hideHeadlines = true;
    }
  },

  computed: {
    ...mapState('userFolder', ['selectedFolderId']),
    ...mapState('userFolder', ['selectedOrgFolderId']),
  },

  methods: {
    openLogin() {
      this.hideHeadlines = false;
      this.$emit('openLogin');
    },
  },
}
</script>

<style lang="scss" scoped>
.list-login {
  padding: 25px 20px 0 20px;
  border-right: 1px solid #a3a3a3;
  font-size: 16px;
  transition: width .45s;

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
