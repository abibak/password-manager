<template>

  <div class="container-login">

    <form @submit.prevent>

      <LoginInput />

    </form>

  </div>

</template>

<script>
import LoginInput from "@/components/LoginPage/LoginInput";

export default {
  name: "Login",

  components: {
    LoginInput
  },
}
</script>

<style scoped>

</style>
