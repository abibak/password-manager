<template>
  <div class="confirm-delete">
    <div class="container-confirm">
      <BaseCloseModal @click="closeConfirm"></BaseCloseModal>

      <div class="confirm">
        <i class="bi bi-trash3"></i>
        <p class="text-confirm">Вы уверены, что хотите удалить папку</p>
        <p class="name-folder-delete">"{{ nameFolder }}"</p>

        <BaseButton class="btn-delete-folder" @click="deleteFolder">Удалить</BaseButton>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapMutations, mapState} from "vuex";

export default {
  name: "ConfirmDeleteFolder",

  props: {
    nameFolder: {
      type: String,
      required: true,
    },
  },

  computed: {
    ...mapState(['typeFolder']),
  },

  methods: {
    ...mapMutations(['setShowModalConfirmDelete']),
    ...mapActions('folder', ['sendRequestDeleteFolder']),

    deleteFolder() {
      this.setShowModalConfirmDelete(false);
      this.sendRequestDeleteFolder();
    },

    closeConfirm() {
      this.setShowModalConfirmDelete(false);
    },
  }
}
</script>

<style lang="scss" scoped>
.confirm-delete {
  width: 300px;
  background-color: #fff;
  border-radius: 14px;
  color: #000;
  text-align: center;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  .container-confirm {
    padding: 30px;
    position: relative;

    .confirm {
      display: flex;
      flex-direction: column;
      align-items: center;

      .bi-trash3 {
        font-size: 74px;
        padding-top: 10px;
      }

      .text-confirm {
        width: 70%;
        padding-top: 35px;
        font-size: 20px;
      }

      .name-folder-delete {
        padding-top: 5px;
      }

      .btn-delete-folder {
        margin-top: 35px;
        background-color: $colorRemove;
        transition: opacity $transTime;

        &:hover {
          background-color: $hoverRemove;
        }
      }
    }
  }
}
</style>
