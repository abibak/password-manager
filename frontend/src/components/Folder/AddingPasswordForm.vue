<template>
  <div class="adding-password" :style="width">
    <div class="container-adding">
      <BaseCloseModal @click="setShowModalAddingPassword(false)"></BaseCloseModal>

      <p class="name-action">Добавить пароль</p>

      <form @submit.prevent>
        <div class="element-form">
          <label for="addName">Название</label>
          <BaseInput id="addName" v-model.trim="form.fields.name" :value="form.fields.name"></BaseInput>
        </div>

        <div class="element-form">
          <label for="addLogin">Логин</label>
          <BaseInput id="addLogin" v-model.trim="form.fields.login"></BaseInput>
          <i class="bi bi-clipboard"></i>
        </div>

        <div class="element-form">
          <label for="addPassword">Пароль <span class="generate-password" @click="generatePassword">Сгенерировать</span></label>
          <BaseInput id="addPassword" :type="form.types.password" v-model.trim="form.fields.password"></BaseInput>
          <i :class="form.showPassClass" @click="showPassword"></i>
          <i class="bi bi-gear" @click="showGenerationPassword = true"></i>
          <i class="bi bi-clipboard"></i>
        </div>

        <div class="element-form">
          <label for="addUrl">URL</label>
          <BaseInput id="addUrl" v-model.trim="form.fields.url"></BaseInput>
          <i class="bi bi-clipboard"></i>
        </div>

        <div class="element-form">
          <label for="addTag">Теги</label>
          <BaseInput id="addTag" placeholder="social, admin" v-model.trim="form.fields.tags"></BaseInput>
          <i class="bi bi-clipboard"></i>
        </div>

        <div class="element-form">
          <label for="addNote">Заметка</label>
          <textarea id="addNote" v-model.trim="form.fields.note"></textarea>
        </div>

        <div class="element-form input-file">
          <label for="file"><i class="bi bi-plus-circle"></i>Выбрать файл</label>
          <input type="file" id="file" ref="input-file" @change="fileUpload">
        </div>

        <BaseButton @click="sendDataForm(), setShowModalAddingPassword(false)">Сохранить</BaseButton>
      </form>
    </div>
  </div>

  <BaseModal v-model:show="showGenerationPassword">
    <PasswordGenerationSettings @closeGeneration="closeGeneration"
                                @getPassword="setPassword"></PasswordGenerationSettings>
  </BaseModal>
</template>

<script>
import PasswordGenerationSettings from "@/components/Folder/PasswordGenerationSettings";
import {mapActions, mapMutations} from "vuex";

export default {
  name: "AddingPasswordForm",
  components: {PasswordGenerationSettings},

  data() {
    return {
      width: 'width: auto',

      form: {
        types: {
          password: 'password',
        },

        fields: {
          name: 'Новый пароль',
          login: 'sdfsdf',
          password: 'sdfdsf',
          url: 'sdfsdf',
          tags: 'sdfsdf',
          note: 'sdfsdsdf',
        },
        showPassClass: 'bi bi-eye'
      },
      showGenerationPassword: false,
    }
  },

  watch: {
    showGenerationPassword() {
      if (this.showGenerationPassword) {
        return this.width = 'opacity: 0';
      }

      return this.width = 'opacity: 1';
    }
  },

  methods: {
    ...mapActions('userFolderData', {
      sendRequestCreatePassword: 'sendRequestCreatePassword',
    }),
    ...mapMutations('userFolderData', {
      setShowModalAddingPassword: 'setShowModalAddingPassword',
    }),

    fileUpload() {
      this.form.fields.file = this.$refs['input-file'].files[0];
    },

    sendDataForm() {
     /* let formData = new FormData();
      formData.append('file', this.form.fields.file);*/

      this.sendRequestCreatePassword(this.form.fields);
    },

    showPassword() {
      if (this.form.types.password === 'password') {
        this.form.showPassClass = 'bi bi-eye-slash';
        return this.form.types.password = 'text';
      }

      this.form.showPassClass = 'bi bi-eye';
      return this.form.types.password = 'password';
    },

    generatePassword() {
      console.log(this.$refs);
    },

    setPassword(password) {
      this.form.fields.password = password;
    },

    closeGeneration() {
      this.showGenerationPassword = false;
    }
  }
}
</script>

<style lang="scss" scoped>
.adding-password {
  max-height: 860px;
  background-color: #fff;
  border-radius: 10px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  transition: width $transTime;
  overflow: hidden;

  .container-adding {
    padding: 20px;

    .name-action {
      font-size: 22px;
      color: #000;
    }

    form {
      .input-file {
        font-size: 16px;

        label {
          cursor: pointer;
        }

        input {
          display: none;
        }

        i {
          font-size: 18px;
          padding-right: 8px;
          position: sticky !important;
        }
      }

      .element-form {
        width: 440px;
        margin-top: 20px;
        position: relative;

        &:first-child {
          margin-top: 15px;
        }

        #password {
          padding-right: 78px;
        }

        textarea {
          display: block;
          max-width: 440px;
          min-width: 100%;
          max-height: 350px;
          min-height: 100px;
          outline: none;
          border: 1px solid $color;
          border-radius: 8px;
          margin-top: 15px;
          padding: 10px;
          font-size: 16px;
          transition: border-color $transTime;

          &:focus {
            border-color: $backgroundColor;
          }
        }

        .generate-password {
          color: $backgroundColor;
          font-size: 14px;
          padding-left: 10px;
          cursor: pointer;
        }

        label {
          font-weight: 400;
          font-size: 16px;
        }

        .base-input {
          width: 100%;
          padding: 5px 0;
          font-size: 16px;
        }

        i {
          position: absolute;
          right: 0;
          bottom: 5px;
          cursor: pointer;
        }

        .bi-gear {
          padding-right: 28px;

          &:hover {
            color: $colorHover;
          }
        }

        .bi-eye, .bi-eye-slash {
          padding-right: 56px;
        }
      }

      .base-button {
        margin-top: 22px;
      }
    }

  }
}
</style>
