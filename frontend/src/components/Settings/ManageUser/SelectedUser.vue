<template>
  <div class="selected-user">
    <div class="container-selected-user">
      <div class="header-content" @click="$emit('closeSelectedUser')">
        <div class="back">
          <div class="icon-control">
            <i class="bi bi-arrow-left"></i>
            <span>{{ user.login }}<span class="user-email">({{ user.email }})</span></span>
          </div>
        </div>

        <span class="text-settings">Настройки</span>
      </div>

      <div class="content">
        <div class="list-folders">
          <div class="name-attributes">
            <span>Папки</span>
            <span>Доступ</span>
          </div>

          <div class="folder" v-for="folder of folders">
            <span>{{ folder.name }}</span>
            <span>{{ this.getNameAccessFolder(folder.access) }}</span>
          </div>
        </div>

        <div class="menu-settings">
          <div class="icon-control" @click="changeStatusDeactivateAccount(user.id)">
            <i class="bi bi-slash-circle"></i>
            <span>{{ getTextStatusDeactivate }}</span>
          </div>

          <div class="icon-control">
            <i class="bi bi-pencil-square"></i>
            <span>Редактировать</span>
          </div>

          <div class="icon-control" @click="sendRequestDeleteUser(user.id)">
            <i class="bi bi-trash3"></i>
            <span>Удалить пользователя</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {instance} from "@/store";
import {mapActions} from "vuex";

export default {
  name: "SelectedUser",

  props: {
    user: {
      type: Object,
      required: true,
    }
  },

  data() {
    return {
      folders: null,
    }
  },

  created() {
    this.getOrgFoldersUser();
  },

  watch: {
    user() {
      this.getOrgFoldersUser();
    },
  },

  computed: {
    getTextStatusDeactivate() {
      let status = this.user.is_deactivate;
      return (status === 1 || status === true) ? 'Активировать' : 'Деактивировать';
    },
  },

  methods: {
    ...mapActions({
      changeStatusDeactivateAccount: 'account/changeStatusDeactivateAccount',
      sendRequestDeleteUser: 'sendRequestDeleteUser'
    }),

    getNameAccessFolder(access) {
      switch (parseInt(access)) {
        case 3:
          return 'Полный доступ';
        case 2:
          return 'Редактирование';
        case 1:
          return 'Просмотр';
      }
    },

    async getOrgFoldersUser() {
      instance.get(process.env.VUE_APP_API_URL + 'organization/folder/' + this.user.id).then(response => {
        this.folders = response.data.data;
      });
    },
  },
}
</script>

<style lang="scss" scoped>
.selected-user {
  width: 100%;

  .container-selected-user {
    .header-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 20px 0;

      .text-settings, .back {
        border-bottom: 1px solid $color;
      }

      .text-settings {
        width: 40%;
        font-size: 20px;
        padding: 0 0 16px 0; /* 16 px снизу, 1px плюсом из-за иконки внутри элемента .back */
        color: #000;
      }

      .back {
        width: 80%;
        cursor: pointer;
        padding-bottom: 15px;
        margin-right: 20px;

        .icon-control {
          display: flex;
          align-items: center;
          margin-bottom: 0;

          span {
            padding-left: 8px;
            font-size: 20px;
            color: #000;

            .user-email {
              color: $color;
              font-size: 18px;
            }
          }

          i {
            font-size: 22px;
          }
        }
      }
    }

    .content {
      display: flex;
      justify-content: space-between;

      .list-folders {
        width: 80%;
        margin-right: 20px;

        .name-attributes {
          display: flex;
          justify-content: space-between;
          color: #000;
          text-transform: uppercase;

          span {
            width: 35%;
          }
        }

        .folder {
          display: flex;
          justify-content: space-between;
          margin-top: 15px;
          color: #000;
          font-weight: 400;

          span {
            width: 35%;
          }
        }
      }

      .menu-settings {
        width: 40%;

        .icon-control {
          margin-bottom: 10px;
          cursor: pointer;

          &:first-child:hover, &:last-child:hover {
            color: $colorRemove;
          }

          &:hover {
            color: $color;
          }

          i {
            font-size: 22px;
          }

          span {
            padding-left: 8px;
          }
        }
      }
    }
  }
}
</style>
