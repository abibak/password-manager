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

      <SelectedUser @closeSelectedUser="closeSelectedUser"
                    v-if="selectedUser"
                    v-model:user="selectedUser">
      </SelectedUser>

      <ListRoles v-model:show="roleManage.active"></ListRoles>

      <div class="block-manage">
        <div class="container-left-section">
          <div class="block-search" v-show="userManage.active">
            <i class="bi bi-search"></i>

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
              <input type="checkbox" id="user" class="custom-checkbox" v-model="selectedUserIds" :value="user.id">
              <label for="user"></label>

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
import ListRoles from "@/components/Settings/ListRoles";

export default {
  name: "ListUsers",
  components: {
    CreateUserForm,
    SelectedUser,
    ListRoles,
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

  watch: {
    users() {
      this.selectedUser = null;
      this.userManage.active = true;
    }
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
        const userLogin = item.login.toLowerCase();

        if (userLogin.indexOf(this.search.toLowerCase()) !== -1) {
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
      margin-top: 25px;

      .container-left-section {
        width: 70%;

        .block-search .base-input {
          width: 70%;
        }

        .block-search {
          display: flex;
          align-items: center;


          .base-input {
            padding-left: 28px;
          }

          .bi-search {
            color: #000;
            position: absolute;
          }
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

            .custom-checkbox {
              width: 20px;
              height: 20px;
              position: absolute;
              opacity: 0;
            }

            .custom-checkbox+label {
              display: flex;
              align-items: center;
              user-select: none;
            }

            .custom-checkbox+label::before {
              content: '';
              display: inline-block;
              width: 18px;
              height: 18px;
              border: 1px solid $color;
              border-radius: 5px;
              background-repeat: no-repeat;
              background-position: center center;
              background-size: 50% 50%;
              transition: all $transTime;
            }

            .custom-checkbox:checked+label::before {
              border-color: #0b76ef;
              background-color: #0b76ef;
              background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' \
              viewBox='0 0 8 8'%3e%3cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3e%3c/svg%3e");
            }

            .custom-checkbox:not(:disabled):not(:checked)+label:hover::before {
              border-color: #b3d7ff;
            }
            /* стили для активного состояния чекбокса (при нажатии на него) */
            .custom-checkbox:not(:disabled):active+label::before {
              background-color: #b3d7ff;
              border-color: #b3d7ff;
            }
            /* стили для чекбокса, находящегося в фокусе и не находящегося в состоянии checked */
            .custom-checkbox:focus:not(:checked)+label::before {
              border-color: #80bdff;
            }
            /* стили для чекбокса, находящегося в состоянии disabled */
            .custom-checkbox:disabled+label::before {
              background-color: #e9ecef;
            }


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
