<template>
  <div class="create-user" v-if="show">
    <div class="container-create-user">
      <p class="name-action">Создать пользователя</p>

      <form @submit.prevent>
        <div class="element-form">
        </div>

        <div class="element-form">
        </div>

        <BaseButton>Сохранить</BaseButton>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "CreateUserForm",

  props: {
    show: {
      type: Boolean,
      required: true,
      default: false,
    }
  }
}
</script>

<style scoped>

</style>
