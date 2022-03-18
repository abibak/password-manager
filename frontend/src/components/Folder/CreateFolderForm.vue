<template>
  <div class="modal-shadow">
    <div class="create-folder">
      <i class="bi bi-x" @click="closeForm"></i>
      <p class="name-action">Создать папку</p>

      <form @submit.prevent>
        <div class="element-form">
          <label for="name-folder">Имя папки</label>
          <BaseInput id="name-folder" v-model.trim="nameFolder" :style="{borderBottomColor: errorInput}"></BaseInput>
          <span class="error-message" v-if="errors">{{ this.errors.name[0] }}</span>
        </div>

        <BaseButton @click="addFolder">Создать папку</BaseButton>
      </form>
    </div>
  </div>
</template>

<script>
import {instance} from '@/store';
import BaseInput from "@/components/UI/BaseInput";
import {mapState} from "vuex";

export default {
  name: "CreateFolderForm",
  components: {
    BaseInput,
  },

  data() {
    return {
      nameFolder: '',
      errorInput: '',
    }
  },

  computed: {
    ...mapState(['errors']),
  },

  methods: {
    addFolder() {
      if (this.nameFolder === '') {
        return this.errorInput = 'red';
      }

      instance.post(process.env.VUE_APP_API_URL + 'user/folders', {
        name: this.nameFolder,
      }).then(response => {
        if (response.status === 201) {
          this.closeForm();
          this.$store.actions.auth.sendRequestGetFolders();
        }
      }).catch(error => {
        if (error.response?.status === 400) {
          this.errorInput = 'red';
        }
      });
    },

    closeForm() {
      this.$emit('closeForm', false);
    }
  }
}
</script>

<style lang="scss" scoped>
.modal-shadow {
  height: 100%;
  width: 100%;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;
  background: rgba(0, 0, 0, .39);

  html {
    overflow: hidden;
  }

  .create-folder {
    display: inline-block;
    color: #000;
    background-color: #fff;
    border-radius: 10px;
    padding: 15px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    .bi-x {
      font-size: 34px;
      cursor: pointer;
      position: absolute;
      top: 0;
      right: 0;

      &:hover {
        color: #a3a3a3;
      }
    }

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
        width: 390px;
        padding: 5px 0;
        font-size: 16px;
        transition: border-bottom-color $transTime;
      }
    }
  }
}

</style>
