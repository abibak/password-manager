<template>
  <div class="create-user">
    <div class="container-create-user">
      <BaseCloseModal @click="$emit('closeCreateUserForm')"></BaseCloseModal>

      <p class="name-action">Создать пользователя</p>

      <form @submit.prevent>
        <div class="element-form">
          <label for="login">Логин</label>
          <BaseInput :type="`text`" id="login" :value="form.login" v-model.trim="form.login"></BaseInput>
        </div>

        <div class="element-form">
          <label for="status">Статус</label>
          <BaseInput :type="`text`" id="status" value="Пользователь" disabled></BaseInput>
        </div>

        <div class="element-form">
          <label for="roles">Роли</label>

          <select id="roles" v-model="form.roleId">
            <option v-for="role of roles" :value="role.id">{{role.name}}</option>
          </select>
        </div>

        <div class="element-form">
          <label for="email">Email</label>
          <BaseInput :type="`email`" id="email" v-model.trim="form.email"></BaseInput>
        </div>
      </form>

      <BaseButton @click="createUser">Сохранить</BaseButton>
    </div>
  </div>
</template>

<script>
import {mapActions, mapState} from "vuex";

export default {
  name: "CreateUserForm",

  data() {
    return {
      form: {
        roleId: null,
        login: 'Новый пользователь',
        email: '',
      },
    }
  },

  created() {
    this.sendRequestGetRoles();
  },

  computed: {
    ...mapState(['roles']),
  },

  methods: {
    ...mapActions(['sendRequestGetRoles', 'sendRequestCreateUser']),

    createUser() {
      if (this.form.roleId !== null && this.form.login !== '' && this.form.email !== '') {
        this.$emit('closeCreateUserForm');
        this.sendRequestCreateUser(this.form);
      }
    },
  },
}
</script>

<style lang="scss" scoped>
  .create-user {
    width: 55%;
    padding: 40px;
    background-color: #fff;
    border-radius: 10px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);

    .container-create-user {
      .base-button {
        margin-top: 30px;
      }

      form {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 30px;

        .element-form {
          display: flex;
          flex: 0 0 22%;
          flex-direction: column;
          font-size: 16px;

          .base-input {
            width: 100%;
          }
        }

        .element-form:nth-of-type(3) {
          line-height: 35px;

          #roles {
            border: none;
            outline: none;
            border-bottom: 1px solid $color;
            transition: border-bottom-color $transTime;

            &:hover {
              border-bottom-color: $baseColor;
            }
          }
        }
      }
    }
  }
</style>
