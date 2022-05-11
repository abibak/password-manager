<template>
  <div class="create-role">
    <div class="container-create-role">
      <BaseCloseModal @click="this.$emit('closeCreateRoleForm')"></BaseCloseModal>

      <p class="name-action">Создать роль</p>

      <form @submit.prevent>
        <div class="element-form">
          <label for="login">Название</label>
          <BaseInput :type="`text`" id="login" v-model.trim="form.name"></BaseInput>
        </div>

        <div class="element-form">
          <label for="status">Уровень доступа</label>
          <select name="access" id="access" v-model.number="form.access">
            <option value="1">Просмотр</option>
            <option value="2">Редактирование</option>
            <option value="3">Полный доступ</option>
          </select>
        </div>
      </form>

      <BaseButton @click="sendRequestCreateRole">Сохранить</BaseButton>
    </div>
  </div>
</template>

<script>
import {instance} from "@/store";
import {mapActions} from "vuex";

export default {
  name: "CreateRoleForm",
  components: {},

  data() {
    return {
      form: {
        name: 'Новая роль',
        access: null,
      },
    }
  },

  methods: {
    ...mapActions(['sendRequestGetRoles']),
    async sendRequestCreateRole() {
      this.$emit('closeCreateRoleForm');

      if (this.name !== '' && this.form.access !== null) {
        instance.post(process.env.VUE_APP_API_URL + 'role', this.form).then(response => {
          if (response.status === 201) {
            this.sendRequestGetRoles();
          }
        })
      }
    }
  },
}
</script>

<style lang="scss" scoped>
.create-role {
  width: 35%;
  padding: 40px;
  background-color: #fff;
  border-radius: 10px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  .container-create-role {
    form {
      .element-form {
        display: flex;
        flex-direction: column;
        margin-top: 20px;
        font-size: 16px;

        &:nth-of-type(2) {
          line-height: 34px;
        }
      }

      #access {
        border: none;
        outline: none;
        border-bottom: 1px solid $color;
        transition: border-bottom-color $transTime;

        &:hover {
          border-bottom-color: $baseColor;
        }
      }
    }

    .base-button {
      margin-top: 30px;
    }
  }
}
</style>
