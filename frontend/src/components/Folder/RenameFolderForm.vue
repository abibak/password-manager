<template>
  <div class="rename-folder">
    <div class="container-rename">
      <BaseCloseModal @closeModal="closeForm"></BaseCloseModal>

      <p class="name-action">Переименовать папку</p>

      <form @submit.prevent>
        <div class="element-form">
          <label for="newName">Новое имя папки</label>
          <BaseInput
            id="newName"
            v-model.trim="newName"
            v-model:value="newName"
            :style="{borderBottomColor: errorColorInput}">
          </BaseInput>
        </div>

        <BaseButton @click="renameFolder">Сохранить</BaseButton>
      </form>
    </div>
  </div>
</template>

<script>
import {mapActions, mapMutations} from "vuex";

export default {
  name: "RenameFolderForm",

  props: {
    nameFolder: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      newName: this.nameFolder,
      errorColorInput: '',
    }
  },

  methods: {
    ...mapActions('folder', ['sendRequestRenameFolder']),
    ...mapMutations(['setShowModalRenameFolder']),

    renameFolder() {
      if (this.newName === '') {
        return this.errorColorInput = 'rgba(219, 31, 31, 1)';
      } else if (this.nameFolder !== this.newName) {
        this.closeForm();
        this.sendRequestRenameFolder(this.newName);
      }
    },

    closeForm() {
      this.setShowModalRenameFolder(false);
    },
  },
}
</script>

<style lang="scss" scoped>
.rename-folder {
  display: inline-block;
  color: #000;
  background-color: #fff;
  border-radius: 10px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  .container-rename {
    padding: 20px;

    .name-action {
      font-size: 22px;
    }

    .element-form {
      position: relative;
    }

    .base-button {
      margin-top: 22px;
    }

    .element-form {
      margin-top: 18px;

      label:first-child {
        font-weight: 400;
        font-size: 14px;
        color: #a3a3a3;
      }

      .base-input {
        width: 460px;
        padding: 5px 0;
        font-size: 16px;
        transition: border-bottom-color $transTime;
      }
    }
  }
}
</style>
