<template>
  <div class="settings-authorization">
    <div class="container-settings">
      <p class="auth-settings">Настройки авторизации</p>

      <form @submit.prevent>
        <label for="old-password">Текущий пароль</label>
        <BaseInput :type="'password'" id="old-password"></BaseInput>

        <label for="new-password">Текущий пароль</label>
        <BaseInput :type="'password'" id="new-password"></BaseInput>

        <label for="repeat-password">Текущий пароль</label>
        <BaseInput :type="'password'" id="repeat-password"></BaseInput>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "SettingsAuthorization",
}
</script>

<style lang="scss" scoped>

</style>
