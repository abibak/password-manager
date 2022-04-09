<template>
  <div class="invite-folder">
    <div class="container-invite">
      <BaseCloseModal @click="setShowInviteFolder(false)"></BaseCloseModal>

      <p class="name-action">Пригласить в папку "{{ this.nameFolder }}"</p>

      <form @submit.prevent>
        <div class="form-items">
          <div class="element-form">
            <label for="login-user">Логин пользователя</label>

            <select id="login-user" name="login-user" v-model="selectUserId">
              <option :value="item.id" v-for="(item) of this.userLogins">{{ item.login }} . {{ item.id }}</option>
            </select>
          </div>

          <div class="element-form">
            <label for="invite-right">Пригласить с правами</label>

            <select id="invite-right" v-model="selectAccess">
              <option value="1" selected>Только чтение</option>
              <option value="2">Редактирование</option>
              <option value="3">Полный доступ</option>
            </select>
          </div>
        </div>

        <BaseButton @click="inviteToFolder">Отправить</BaseButton>
      </form>
    </div>
  </div>
</template>

<script>
import {instance} from '@/store';
import {mapActions, mapGetters, mapMutations, mapState} from "vuex";

export default {
  name: "InviteToFolder",

  props: {
    nameFolder: {
      type: String,
      required: true,
      default: '',
    }
  },

  data() {
    return {
      userLogins: [],
      selectAccess: '1',
      selectUserId: '',
    }
  },

  created() {
    this.getLogins();
  },

  computed: {
    ...mapState('auth', ['userData']),
    ...mapGetters('organizationFolder', ['getOrgLogins']),
  },

  methods: {
    ...mapActions('organizationFolder', {
      sendInviteToFolder: 'sendInviteToFolder',
    }),
    ...mapMutations('organizationFolder', {
      setShowInviteFolder: 'setShowInviteFolder',
      setUserAccess: 'setUserAccess',
    }),

    inviteToFolder() {
      this.setShowInviteFolder(false);
      this.sendInviteToFolder({
        user_id: this.selectUserId,
        access: this.selectAccess,
      });
    },

    iterateArray(arr, key) {
      let ids = [];

      for (let item in arr) {
        ids.push(arr[item][key]);
      }

      return ids.sort((a, b) => {
        return a - b;
      });
    },

    passArrayToIterate(arr, typeArray = '') {
      if (typeArray === 'usersAccess') {
        return this.iterateArray(arr, 'user_id');
      }
      return this.iterateArray(arr, 'id');
    },

    async getLogins() {
      await instance.get(process.env.VUE_APP_API_URL + '/access/folder')
        .then(response => {
          const users = this.getOrgLogins[0].users;

          let usersAccess = this.passArrayToIterate(users, 'usersAccess'); // пользователи имеющие доступ
          let allUserIds = this.passArrayToIterate(response.data.data); // все пользователи

          for (let i = 0; i < response.data.data.length; i++) {
            const itemResponse = response.data.data[i];
            let resultFindId = !usersAccess.includes(allUserIds[i]);

            if (resultFindId) {
              this.userLogins.push(itemResponse);
            }
          }
        });
    },
  },
}
</script>

<style lang="scss" scoped>

.invite-folder {
  background-color: #fff;
  border-radius: 10px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  transition: width $transTime;
  overflow: hidden;

  .container-invite {
    padding: 20px;

    form {
      margin-top: 15px;

      .form-items {
        display: flex;

        .element-form {
          margin-right: 22px;

          &:last-child {
            margin-right: 0;
          }

          label {
            display: block;
            font-size: 16px;
            padding-bottom: 5px;
          }

          select {
            width: 250px;
            padding: 5px 0;
            font-size: 16px;
            outline: none;
            border: none;
            border-bottom: 1px solid #a3a3a3;
            -o-transition: border-bottom-color $transTime;
            -webkit-transition: border-bottom-color $transTime;
            -moz-transition: border-bottom-color $transTime;
            transition: border-bottom-color $transTime;

            &:hover {
              border-bottom-color: $baseColor;
            }
          }
        }
      }

      .base-button {
        margin-top: 22px;
      }
    }
  }
}

</style>
