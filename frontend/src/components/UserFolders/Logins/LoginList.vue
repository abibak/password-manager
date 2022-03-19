<template>
  <div class="list-login">
    <div class="headlines">
      <div>Название</div>
      <div>Логин</div>
      <div>URL</div>
      <div>Теги</div>
    </div>

    <div class="login">
      <div v-for="(item) of folderData[0].logins">
        <LoginItem :login="item"></LoginItem>
      </div>
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

  .headlines, .login {
    width: 70%;
  }

  .headlines {
    display: flex;
    justify-content: space-between;
    color: #000;
    font-weight: 500;
    text-transform: uppercase;

    div {
      width: 100%;
      font-size: 18px;
      text-align: left;
    }
  }
}
</style>
