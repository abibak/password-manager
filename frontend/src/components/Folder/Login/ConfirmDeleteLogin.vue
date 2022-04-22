<template>
  <div class="confirm-delete">
    <div class="container-confirm">
      <BaseCloseModal @closeModal=""></BaseCloseModal>

      <div class="confirm">
        <i class="bi bi-trash3"></i>
        <p class="text-confirm">Вы уверены, что хотите удалить пароль</p>
        <p class="name-folder-delete">"{{ this.login }}"</p>

        <BaseButton class="btn-delete-folder" @click="deleteLogin">Удалить</BaseButton>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ConfirmDeleteLogin",

  props: {
    login: {
      type: String,
      required: true,
    }
  },

  methods: {
    deleteLogin() {
      console.log('del login');
    },
  },
}
</script>

<style scoped>

</style>
