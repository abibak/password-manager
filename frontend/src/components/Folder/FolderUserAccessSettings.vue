<template>
  <div class="settings-access-user" @click.stop>
    <div class="container-settings-access">
      <BaseCloseModal @click.stop="this.$emit('closeModal')"></BaseCloseModal>

      <p class="name-action">Настройки доступа к папке "{{ folderName }}"</p>

      <div class="head-users">
        <p>Пользователи</p>
      </div>

      <form class="list-users" @submit.prevent>
        <div class="item-user admin">
          <p>{{ owner.login }}</p>
          <p>Администратор</p>
        </div>

        <div class="item-user" v-for="user of users">
          <p>{{ user.login }}</p>

          <select @change="changeUserAccess($event.target, user.id)" v-if="checkOwnerFolder">
            <option value="1" :selected="user.access === 1">Просмотр</option>
            <option value="2" :selected="user.access === 2">Редактирование</option>
            <option value="3" :selected="user.access === 3">Полный доступ</option>
          </select>

          <p v-if="!checkOwnerFolder">Участник</p>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import store, {instance} from "@/store";
import {mapActions, mapMutations, mapState} from "vuex";

export default {
  name: "FolderUserAccessSettings",
  components: {},

  props: {
    folderName: {
      type: String,
      required: true,
      default: 'Название папки',
    },

    users: {
      type: Array,
      required: true,
      default: [],
    },

    owner: {
      type: Object,
      required: true,
      default: {},
    },
  },

  data() {
    return {}
  },

  computed: {
    ...mapState('auth', ['userData']),
    ...mapState('folder', ['selectedOrgFolderId']),

    checkOwnerFolder() {
      return this.userData.id === this.owner.id;
    },
  },

  methods: {
    ...mapActions('folder', ['sendRequestGetOrganizationFolders']),
    ...mapMutations(['setMessages']),

    async changeUserAccess(element, userId) {
      const access = element.value;

      instance.post(process.env.VUE_APP_API_URL + 'folder/access/change/', {
        folder_id: this.selectedOrgFolderId,
        user_id: userId,
        access: access,
      }).then(response => {
        this.setMessages({messages: response.data, typeMessage: 'success'});
        this.sendRequestGetOrganizationFolders();
      })
    },
  },
}
</script>

<style lang="scss" scoped>
.settings-access-user {
  width: 45%;
  display: inline-block;
  color: #000;
  background-color: #fff;
  border-radius: 10px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  .container-settings-access {
    padding: 30px;

    .head-users {
      padding: 20px 0;
      border-bottom: 2px solid $color;
    }

    .list-users {
      padding-top: 20px;

      .admin {
        p:last-child {
          font-size: 16px;
          color: $baseColor
        }
      }

      .item-user {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid $color;

        &:first-child {
          padding-top: 0;
        }

        &:last-child {
          border-bottom: none;
        }

        select {
          width: 25%;
          padding: 5px 0;
          outline: none;
          border: none;
          color: $color;
          transition: border-bottom-color 0.2s;
          cursor: pointer;
        }
      }
    }
  }
}
</style>
