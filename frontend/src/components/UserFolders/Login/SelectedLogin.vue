<template>
  <div class="selected-login" v-if="show">
    <div class="container-selected-login">
      <div class="info-login">
        <p class="name-login">
          <span class="short-name">{{ this.getDataOpenLogin.name.charAt(0) }}</span>
          {{ this.getDataOpenLogin.name }}
        </p>
      </div>

      <div class="icon-actions">
        <i class="bi bi-person-plus"></i>
      </div>

      <div class="list-actions-login">
        <span class="action">Общие</span>
        <span class="action">Файлы</span>
      </div>

      <div class="form-login">
        <form>
          <div class="element-form">
            <label for="name">Название</label>
            <BaseInput id="name-name" :value="getDataOpenLogin.name" disabled></BaseInput>
          </div>

          <div class="element-form">
            <label for="login">Логин</label>
            <BaseInput id="login" :value="getDataOpenLogin.login" disabled></BaseInput>
            <i class="bi bi-clipboard"></i>
          </div>

          <div class="element-form">
            <label for="password">Пароль</label>
            <BaseInput id="password" :value="getDataOpenLogin.password" disabled></BaseInput>
            <i class="bi bi-clipboard"></i>
          </div>

          <div class="element-form">
            <label for="url">URL</label>
            <BaseInput id="url" :value="getDataOpenLogin.url" disabled></BaseInput>
            <i class="bi bi-clipboard"></i>
          </div>

          <div class="element-form">
            <label for="tag">Теги</label>
            <BaseInput id="tag" :value="getDataOpenLogin.tag" disabled></BaseInput>
            <i class="bi bi-clipboard"></i>
          </div>

          <div class="element-form">
            <label for="note">Заметка</label>
            <textarea id="note" :value="getDataOpenLogin.note" disabled></textarea>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
  name: "SelectedLogin",

  props: {
    show: {
      type: Boolean,
      required: true,
    },
  },

  data() {
    return {}
  },

  created() {
    console.log(this.getDataOpenLogin);
  },

  computed: {
    ...mapGetters('userFolderData', {
      setSelectedLoginId: 'setSelectedLoginId',
      getDataOpenLogin: 'getDataOpenLogin',
    })
  },

  methods: {},
}
</script>

<style lang="scss" scoped>
.selected-login {
  .container-selected-login {
    padding: 25px 0 0 20px;

    .info-login {
      .name-login {
        font-size: 22px;
        color: #000;
      }

      .short-name {
        display: inline-block;
        width: 30px;
        height: 30px;
        line-height: 30px;
        padding: 0 5px;
        margin-right: 10px;
        text-transform: uppercase;
        text-align: center;
        color: #fff;
        border-radius: 6px;
        background-color: $backgroundColor;
      }
    }

    form {
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

        .bi-eye, .bi-eye-slash {
          padding-right: 56px;
        }
      }
    }
  }
}
</style>
