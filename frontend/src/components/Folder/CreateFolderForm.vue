<template>
  <div class="create-folder">
    <BaseCloseModal @closeModal="closeForm"></BaseCloseModal>
    <p class="name-action">Создать папку</p>

    <form @submit.prevent>
      <div class="element-form">
        <label for="name-folder">Имя папки</label>
        <BaseInput id="name-folder" v-model.trim="nameFolder" :style="{borderBottomColor: errorInput}"></BaseInput>
      </div>

      <BaseButton @click="addFolder">Сохранить</BaseButton>
    </form>
  </div>
</template>

<script>
import {mapActions, mapMutations, mapState} from "vuex";
import BaseInput from "@/components/UI/BaseInput";

export default {
  name: "CreateFolderForm",
  components: {
    BaseInput,
  },

  props: {
    typeFolder: {
      type: String,
      required: true,
    },
  },

  data() {
    return {
      nameFolder: '',
      errorInput: '',
    }
  },

  methods: {
    ...mapActions({
      sendRequestCreateFolder: 'folder/sendRequestCreateFolder',
    }),

    ...mapMutations('folder', {
      setTypeFolder: 'setTypeFolder',
    }),

    addFolder() {
      if (this.nameFolder === '') {
        return this.errorInput = 'red';
      }

      if (this.typeFolder === 'orgFolder') {
        this.setTypeFolder(this.typeFolder);
      } else {
        this.setTypeFolder(this.typeFolder);
      }

      this.sendRequestCreateFolder(this.nameFolder);
      this.closeForm();
    },

    closeForm() {
      this.$emit('closeForm');
    }
  }
}
</script>

<style lang="scss" scoped>
.create-folder {
  color: #000;
  background-color: #fff;
  border-radius: 10px;
  padding: 20px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

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
      font-size: 16px;
      color: #a3a3a3;
    }

    .base-input {
      width: 460px;
      padding: 5px 0;
      background-color: transparent;
      font-size: 16px;
      transition: border-bottom-color $transTime;
    }
  }
}
</style>
