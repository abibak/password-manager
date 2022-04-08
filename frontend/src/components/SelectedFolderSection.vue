<template>
  <div class="selected-folder-section">
    <div class="container-folder-section">

      <div class="header-info-folder">
        <div class="container-header-info">
          <p class="name-folder">{{ this.currentFolder[0].name }}</p>

          <div class="unit-folder-control">
            <div class="icon-control icon-invite-user" v-if="this.typeFolder === 'orgFolder'" @click="setShowInviteFolder(true)">
              <i class="bi bi-person-plus"></i>
            </div>

            <div class="icon-control icon-options" @click="showSettings = !showSettings">
              <i class="bi bi-three-dots"></i>
              <SettingsFolder v-model:show="showSettings"></SettingsFolder>
            </div>

            <BaseButton @click="setShowModalAddingPassword(true)">Добавить пароль</BaseButton>
          </div>
        </div>

        <div class="info-users" v-if="typeFolder === 'orgFolder'">
          <span v-if="this.currentFolder[0].users.length !== 0">
            Еще <span class="view-users">{{this.currentFolder[0].users.length}} сотрудников</span> могут просматривать папку
          </span>

          <span v-if="this.currentFolder[0].users.length === 0">
            <span>В папке отсутствуют пользователи</span>
          </span>
        </div>
      </div>

      <BaseModal v-model:show="showModalAddingPassword">
        <AddingPasswordForm></AddingPasswordForm>
      </BaseModal>

      <!--    форма переименования папки    -->
      <BaseModal v-model:show="showModalRenameFolder">
        <RenameFolderForm :name-folder="this.currentFolder[0].name"></RenameFolderForm>
      </BaseModal>

      <!--    Подтверждение удаления папки    -->
      <BaseModal v-model:show="showModalConfirmDelete">
        <ConfirmDeleteFolder
          :name-folder="getLogins[0].name">
        </ConfirmDeleteFolder>
      </BaseModal>

      <!--    Список паролей    -->
      <div class="open-login-container">
        <LoginList @openLogin="showOpenLogin" :folder-data="this.currentFolder"
                   :width-value="loginListWidth"></LoginList>
        <SelectedLogin @close="closeLoginView" :show="showSelectedLogin.show"></SelectedLogin>
      </div>

      <BaseModal v-model:show="showInviteFolder">
        <InviteToFolder :name-folder="this.currentFolder[0].name"></InviteToFolder>
      </BaseModal>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapMutations, mapState} from "vuex";
import LoginList from "@/components/UserFolders/Login/LoginList";
import SettingsFolder from "@/components/Folder/SettingsFolder";
import ConfirmDeleteFolder from "@/components/Folder/ConfirmDeleteFolder";
import RenameFolderForm from "@/components/Folder/RenameFolderForm";
import AddingPasswordForm from "@/components/Folder/AddingPasswordForm";
import SelectedLogin from "@/components/UserFolders/Login/SelectedLogin";
import InviteToFolder from "@/components/Folder/InviteToFolder";

export default {
  name: "SelectedFolderSection",

  components: {
    LoginList,
    SettingsFolder,
    ConfirmDeleteFolder,
    RenameFolderForm,
    AddingPasswordForm,
    SelectedLogin,
    InviteToFolder,
  },

  data() {
    return {
      currentFolder: '',

      showSettings: false,
      loginListWidth: 80,
      logins: '',

      showSelectedLogin: {
        show: false,
      },
    }
  },

  created() {
    if (this.typeFolder === 'orgFolder') {
      this.currentFolder = this.getOrgLogins;
    } else if (this.typeFolder === 'userFolder') {
      this.currentFolder = this.getLogins;
    }
  },

  watch: {
    selectedFolderId() {
      if (this.selectedFolderId !== null) {
        this.closeLoginView();
        this.currentFolder = this.getLogins;
      }
    },

    selectedOrgFolderId() {
      if (this.selectedOrgFolderId !== null) {
        this.closeLoginView();
        this.currentFolder = this.getOrgLogins;
      }
    },


    // old variant
    /*selectedFolderId() {
      if (this.selectedFolderId === null) {
        return this.closeLoginView();
      }
      this.closeLoginView();
      this.currentFolder = this.getLogins;
    },

    selectedOrgFolderId() {
      if (this.selectedOrgFolderId === null) {
        return this.closeLoginView();
      }
      this.closeLoginView();
      this.currentFolder = this.getOrgLogins;
    },*/
  },

  computed: {
    ...mapState(['typeFolder']),
    ...mapState('organizationFolder', ['selectedOrgFolderId', 'showInviteFolder']),
    ...mapState('userFolder', [
      'selectedFolderId',
      'showModalConfirmDelete',
      'showModalRenameFolder',
      'showModalAddingPassword'
    ]),
    ...mapGetters('userFolder', ['getLogins']),
    ...mapGetters('organizationFolder', ['getOrgLogins']), // organization namespace
  },

  methods: {
    ...mapMutations('userFolder', {
      setShowModalConfirmDelete: 'setShowModalConfirmDelete',
      setShowModalRenameFolder: 'setShowModalRenameFolder',
      setShowModalAddingPassword: 'setShowModalAddingPassword',
    }),
    // organization namespace
    ...mapMutations('organizationFolder', {
      setShowInviteFolder: 'setShowInviteFolder',
    }),

    closeFormRenameFolder() {
      this.setShowModalRenameFolder(false);
    },

    showOpenLogin() {
      this.showSelectedLogin.show = true;
      this.loginListWidth = 40; // ширина при просмотре
    },

    closeLoginView() {
      this.showSelectedLogin.show = false;
      this.loginListWidth = 80; // ширина секции паролей по умолчанию
    },
  }
}
</script>

<style lang="scss" scoped>
.selected-folder-section {
  .container-folder-section {
    .open-login-container {
      display: flex;
    }
  }

  .name-folder {
    width: 50%;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 24px;
    color: #000;
  }

  .header-info-folder {
    padding: 25px 20px;
    border-bottom: 1px solid $color;

    .container-header-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .info-users {
      display: flex;
      align-items: center;
      margin-top: 5px;

      span:first-child {
        font-size: 16px;

        .view-users {
          color: $baseColor;
          cursor: pointer;
          transition: color $transTime;

          &:hover {
            color: $baseColorHover;
          }
        }
      }
    }

    .unit-folder-control {
      display: flex;
      justify-content: center;
      align-items: center;

      .icon-control {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 36px;
        height: 36px;
        margin-right: 10px;
        border-radius: 50%;
        border: 1px solid #2683e0;
        cursor: pointer;
        position: relative;
      }

      .icon-invite-user {
        background-color: $baseColor;

        .bi-person-plus {
          color: #fff;
        }
      }

      .bi-three-dots {
        font-size: 23px;
        color: #2683e0;
      }
    }
  }
}
</style>