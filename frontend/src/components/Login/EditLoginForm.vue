<template>
  <div class="edit-password">
    <div class="container-edit">
      <BaseCloseModal @click.stop="setShowEditLogin(false)"></BaseCloseModal>

      <p class="name-action">Редактирование пароля</p>

      <form @submit.prevent>
        <div class="element-form">
          <label for="addName">Название</label>
          <BaseInput id="addName" v-model.trim="form.login.name" :value="form.login.name"></BaseInput>
        </div>

        <div class="element-form">
          <label for="addLogin">Логин</label>
          <BaseInput id="addLogin" v-model.trim="form.login.login"></BaseInput>
          <BaseClipboard :value="form.login.login"></BaseClipboard>
        </div>

        <div class="element-form">
          <label for="addPassword">Пароль <span class="generate-password" @click="generatePassword">Сгенерировать</span></label>
          <BaseInput id="addPassword" :type="form.types.password" v-model.trim="form.login.password"></BaseInput>
          <i :class="form.showPassClass" @click="showPassword"></i>
          <i class="bi bi-gear" @click="showGenerationPassword = true"></i>
          <i class="bi bi-clipboard"></i>
        </div>

        <div class="element-form">
          <label for="addUrl">URL</label>
          <BaseInput id="addUrl" v-model.trim="form.login.url"></BaseInput>
          <i class="bi bi-clipboard"></i>
        </div>

        <div class="element-form">
          <label for="addTag">Теги</label>
          <BaseInput id="addTag" placeholder="social, admin" v-model.trim="form.login.tags"></BaseInput>
          <i class="bi bi-clipboard"></i>
        </div>

        <div class="element-form">
          <label for="addNote">Заметка</label>
          <textarea id="addNote" v-model.trim="form.login.note"></textarea>
        </div>

        <div class="element-form input-file">
          <label for="file"><i class="bi bi-plus-circle"></i>Выбрать файл</label>
          <input type="file" id="file" ref="input-file" @change="">
        </div>

        <BaseButton @click="sendDataForm(), setShowEditLogin(false)">Сохранить</BaseButton>
      </form>
    </div>
  </div>

  <BaseModal v-model:show="showGenerationPassword">
    <PasswordGenerationSettings @closeGeneration="closeGeneration"
                                @getPassword="setPassword">
    </PasswordGenerationSettings>
  </BaseModal>
</template>

<script>
import {mapActions, mapGetters, mapMutations, mapState} from "vuex";
import PasswordGenerationSettings from "@/components/Folder/PasswordGenerationSettings";
import BaseClipboard from "@/components/BaseClipboard";

export default {
  name: "EditLoginForm",
  components: {
    PasswordGenerationSettings,
    BaseClipboard,
  },

  data() {
    return {
      form: {
        types: {
          password: 'password',
        },

        login: {},

        showPassClass: 'bi bi-eye'
      },
      showGenerationPassword: false,
    }
  },

  created() {
    this.getDataSelectedLogin();
  },

  computed: {
    ...mapState('folder', ['typeFolder', 'selectedLoginId', 'selectedOrgLoginId']),
    ...mapState('login', ['dataCurrentSelectedLogin']),
  },

  watch: {
    selectedLoginId() {
      this.getDataSelectedLogin();
    },

    selectedOrgLoginId() {
      this.getDataSelectedLogin();
    },

    showGenerationPassword() {
      if (this.showGenerationPassword) {
        return this.width = 'opacity: 0';
      }
      return this.width = 'opacity: 1';
    }
  },

  methods: {
    // organization folder namespace
    ...mapActions('login', ['sendRequestEditLogin']),
    ...mapMutations('login', ['setShowEditLogin']),

    setCurrentLoginData() {
      for (const key in this.dataCurrentSelectedLogin) {
        this.form.login[key] = this.dataCurrentSelectedLogin[key];
      }
    },

    getDataSelectedLogin() {
      if (this.typeFolder === 'orgFolder') {
        this.setCurrentLoginData(this.getDataOrgOpenLogin);
      } else {
        this.setCurrentLoginData(this.getDataOpenLogin);
      }
    },

    sendDataForm() {
      /* let formData = new FormData();
       formData.append('file', this.form.fields.file);*/

      /*if (this.typeFolder === 'orgFolder') {
        return this.sendRequestCreatePassword(this.form.fields);
      }*/

      this.sendRequestEditLogin(this.form.login);
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
  },
}
</script>

<style lang="scss" scoped>
.edit-password {
  max-height: 860px;
  background-color: #fff;
  border-radius: 10px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  transition: width $transTime;
  overflow: hidden;

  .container-edit {
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
            border-color: $baseColor;
          }
        }

        .generate-password {
          color: $baseColor;
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
