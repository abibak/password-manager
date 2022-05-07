<template>
  <div class="manage-users">
    <div class="container-manage-users">
      <p class="name-action">Управление пользователями</p>

      <div class="tabs-list">
        <div class="tab" :class="userManage.classActiveUsersManage" @click="openManageItem">
          <span>Пользователи</span>
        </div>

        <div class="tab" :class="roleManage.classActiveRolesManage" @click="openManageItem">
          <span>Роли</span>
        </div>
      </div>

      <SelectedUser @closeSelectedUser="closeSelectedUser" v-if="selectedUser" :user="selectedUser"></SelectedUser>

      <div class="block-manage">
        <div class="container-left-section">
          <div class="block-search" v-show="userManage.active">
            <BaseInput :type="`search`" v-model="search" placeholder="Поиск"></BaseInput>
          </div>

          <!--    Список всех пользователей    -->
          <div class="list-users" v-show="userManage.active">
            <div class="list-name-attributes">
              <div class="name-attributes">
                <span>Логин</span>
                <span>Роли</span>
                <span>Статус</span>
              </div>
            </div>

            <div class="user" v-for="user of this.getUsers" :key="user.id">
              <input type="checkbox" v-model="selectedUserIds" :value="user.id">

              <div class="attributes" @click.stop="openUser(user)">
                <span>{{ user.login }} <span class="text-admin" v-if="user.is_admin === 1">(Админ)</span></span>

                <span class="roles">
                <span v-for="(roles, index) of user.assigned_roles" :key="roles.id">
                  {{
                    (user.assigned_roles.length > 1 && user.assigned_roles.length !== index + 1) ?
                      roles.role.name + ', ' : roles.role.name
                  }}
                </span>
              </span>
                <!--      Статус        -->
                <span v-if="user.is_admin === 0">Пользователь</span>
                <span v-if="user.is_admin === 1">Админ</span>
              </div>
            </div>
          </div>

          <div class="list-roles" v-show="roleManage.active">
            <h3>Список ролей</h3>

            <div class="role">
              <div class="role-item" v-for="role of roles" :key="role.id">{{ role }}</div>
            </div>
          </div>
        </div>

        <div class="container-right-section" v-show="userManage.active">
          <BaseButton @click="showCreateUserForm = !showCreateUserForm">Создать пользователя</BaseButton>

          <p class="management-description">Вы можете создавать и
            управлять пользователями, настраивать доступ и применять роли</p>

          <div class="action-list">
            <div class="item-action" @click="deleteUser">
              <i class="bi bi-trash3"></i>
              <span>Удалить пользователя</span>
            </div>

            <div class="item-action">
              <i class="bi bi-plus-circle"></i>
              <span>Применить роли</span>
            </div>

            <div class="item-action">
              <i class="bi bi-dash-circle"></i>
              <span>Убрать из ролей</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <BaseModal v-model:show="showCreateUserForm">
      <!--  Форма добавление нового пользователя    -->
      <CreateUserForm @closeCreateUserForm="closeCreateUserForm"></CreateUserForm>
    </BaseModal>
  </div>
</template>

<script>
import {mapActions, mapState} from "vuex";
import CreateUserForm from "@/components/Settings/ManageUsers/CreateUserForm";
import SelectedUser from "@/components/Settings/ManageUsers/SelectedUser";

export default {
  name: "ListUsers",
  components: {
    CreateUserForm,
    SelectedUser
  },

  data() {
    return {
      search: '', // поиск
      userManage: {
        active: true,
        classActiveUsersManage: 'active-tab',
      },

      roleManage: {
        active: false,
        classActiveRolesManage: '',
      },
      selectedUser: null,
      selectedUserIds: [], // массив идентификаторов пользователей
      showCreateUserForm: false,
    }
  },

  created() {
    this.sendRequestGetAllUsers();
    this.sendRequestGetRoles();
  },

  computed: {
    ...mapState(['users', 'roles']),

    getUsers() {
      let foundUsers = [];

      if (this.search === '') {
        return this.users;
      }

      // поиск по логину
      for (const item of this.users) {
        const userLogin = item.login;

        if (userLogin.indexOf(this.search) !== -1) {
          foundUsers.push(item);
        }
      }

      return foundUsers;
    },
  },

  methods: {
    ...mapActions(['sendRequestGetAllUsers', 'sendRequestDeleteUser', 'sendRequestGetRoles']),

    openUser(user) {
      if (user) {
        this.selectedUser = user;

        this.userManage.active = false;
        this.roleManage.active = false;
      }
    },

    deleteUser() {
      if (this.selectedUserIds.length >= 1) {
        let stringIds = this.selectedUserIds.join(',');
        this.sendRequestDeleteUser(stringIds);
      }
    },

    // открыть вкладку управления
    openManageItem(el) {
      const currentElement = el.target.textContent.toLowerCase();
      this.userManage.classActiveUsersManage = '';
      this.roleManage.classActiveRolesManage = '';

      if (currentElement === 'пользователи') {
        this.userManage.classActiveUsersManage = 'active-tab';
        this.userManage.active = true;
        this.roleManage.active = false;
      } else if (currentElement === 'роли') {
        this.roleManage.classActiveRolesManage = 'active-tab';
        this.userManage.active = false;
        this.roleManage.active = true;
      }
    },

    closeSelectedUser() {
      this.selectedUser = false;
      this.userManage.active = true;
    },

    closeCreateUserForm() {
      this.showCreateUserForm = false;
    },
  },
}
</script>

<style lang="scss" scoped>
.manage-users {
  padding: 40px;

  .container-manage-users {
    .name-action {
      font-size: 26px;
    }

    .active-tab {
      color: #000 !important;
      border-bottom-color: $baseColor !important;
      transition: border-bottom-color, color, $transTime;
    }

    .tabs-list {
      display: flex;
      width: 100%;
      margin-top: 30px;
      border-bottom: 1px solid $colorHover;

      .tab {
        padding-bottom: 15px;
        margin-right: 25px;
        font-size: 20px;
        border-bottom: 2px solid transparent;
        color: $color;
        cursor: pointer;
      }
    }

    .block-manage {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;

      .container-left-section {
        width: 70%;

        .block-search .base-input {
          width: 70%;
        }

        .list-users {
          padding-right: 40px;

          .list-name-attributes {
            display: flex;
            align-items: center;
            margin-top: 25px;
            text-transform: uppercase;
            color: #000;

            .name-attributes {
              width: 100%;
              display: flex;
              justify-content: space-between;

              span {
                width: 25%;
                text-align: left;
              }
            }
          }

          .user {
            width: 100%;
            display: flex;
            align-items: center;
            margin-top: 15px;
            cursor: pointer;

            .attributes {
              width: 100%;
              display: flex;
              align-items: center;
              justify-content: space-between;
              margin-left: 8px;
              font-weight: 400;
              color: #000;

              .text-admin {
                font-weight: 500;
              }

              span {
                width: 25%;
                text-align: left;
              }

              .roles {
                font-size: 16px;
                color: $color;
              }
            }
          }
        }
      }

      .container-right-section {
        width: 30%;
        display: flex;
        flex-direction: column;

        .base-button {
          width: 200px;
        }

        .management-description {
          width: 85%;
          color: #000;
          font-weight: 400;
          margin-top: 30px;
        }

        .action-list {
          margin-top: 30px;

          .item-action {
            display: flex;
            align-items: center;
            margin-top: 10px;
            cursor: pointer;
            transition: color $transTime;

            &:hover {
              color: $colorHover;
            }

            &:first-child:hover, &:last-child:hover {
              color: $colorRemove;
            }

            span {
              padding-left: 8px;
            }

            i {
              font-size: 22px;
            }
          }
        }
      }
    }
  }
}
</style>
