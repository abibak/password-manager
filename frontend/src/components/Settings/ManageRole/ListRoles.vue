<template>
  <div class="list-roles" v-if="show">
    <div class="role-manage">
      <div class="container-left-section">
        <div class="name-attributes">
          <span>Роли</span>
          <span>Статус</span>
        </div>

        <div class="role">
          <div class="role-item" v-for="role of roles" :key="role.id">
            <span class="role-name">{{role.name}}</span>

            <div class="elements">
              <BaseToggle @click="role.status = !role.status" v-model:active="role.status"></BaseToggle>
              <i class="bi bi-trash3" @click="sendRequestDeleteRole(role.id)"></i>
            </div>
          </div>
        </div>
      </div>

      <div class="container-right-section">
        <BaseButton @click="showCreateRoleForm = true">Создать роль</BaseButton>
        <p class="management-description">Управляйте ролями. Создавайте и удаляйте роли. Назначайте роли
          пользователям, определеяя их возможности</p>
      </div>
    </div>

    <BaseModal v-model:show="showCreateRoleForm">
      <CreateRoleForm @closeCreateRoleForm="showCreateRoleForm = false"></CreateRoleForm>
    </BaseModal>
  </div>
</template>

<script>
import {mapState} from "vuex";
import {instance} from "@/store";
import CreateRoleForm from "@/components/Settings/ManageRole/CreateRoleForm";

export default {
  name: "ListRoles",
  components: {CreateRoleForm},

  props: {
    show: {
      type: Boolean,
      required: true,
      default: false,
    }
  },

  data() {
    return {
      showCreateRoleForm: false,
    }
  },

  created() {
    this.initData();
  },

  computed: {
    ...mapState(['roles']),
  },

  methods: {
    initData() {
      console.log('init: roles');
    },

    async sendRequestDeleteRole(id) {
      console.log('request/delete: ' + id);

      instance.delete(process.env.VUE_APP_API_URL + 'role/' + id).then(response => {
        console.log(response);
      });
    }
  },
}
</script>

<style lang="scss" scoped>
.list-roles {
  .name-attributes {
    display: flex;
    justify-content: space-between;

    span {
      color: #000;
      text-transform: uppercase;
    }
  }

  .role-manage {
    display: flex;
    margin-top: 25px;

    .container-left-section {
      width: 70%;
      margin-right: 40px;
    }

    .container-right-section {
      width: 40%;

      .management-description {
        width: 85%;
        margin-top: 30px;
        color: #000;
        font-weight: 400;
      }
    }
  }

  .role {
    .role-item {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;

      .role-name {
        display: flex;
      }

      .elements {
        display: flex;
        flex: 0 0 10%;
        justify-content: flex-end;

        .toggle {
          margin-right: 8px;
        }
      }

      i {
        font-size: 22px;
        cursor: pointer;
      }
    }
  }
}
</style>
