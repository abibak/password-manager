<template>
  <div class="list-login">
    <div class="headlines">
      <div>Название</div>
      <div>Логин</div>
      <div>URL</div>
      <div>Теги</div>
    </div>

    <div class="login">
      <LoginItem :login="item" v-for="(item) of folderData[0].logins" :key="item.login_id"></LoginItem>
    </div>
  </div>
</template>

<script>
import LoginItem from "@/components/UserFolders/Logins/LoginItem";

export default {
  name: "LoginList",
  components: {LoginItem},

  props: {
    folderData: {
      required: true,
    }
  },
}
</script>

<style lang="scss" scoped>
.list-login {
  padding: 25px 0 0 20px;
  font-size: 16px;

  .headlines, .login {
    width: 70%;
  }

  .login {
    margin-top: 10px;
  }

  .headlines {
    display: flex;
    justify-content: space-between;
    color: #000;
    font-weight: 500;
    text-transform: uppercase;

    div {
      width: 100%;
      text-align: left;
    }
  }
}
</style>
