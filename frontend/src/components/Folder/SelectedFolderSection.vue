<template>
  <div class="selected-folder-section">
    <div class="container-folder-section">
      <div class="header-info-folder">
        <div class="container-header-info">
          <p class="name-folder">{{ dataCurrentSelectedFolder.name }}</p>

          <div class="unit-folder-control">
            <div class="icon-control icon-invite-user"
                 v-if="typeFolder === 'orgFolder' && userAccess === 3"
                 @click="setShowInviteFolder(true)">
              <i class="bi bi-person-plus"></i>
            </div>

            <div class="icon-control icon-options" v-if="userAccess === 3" @click="showSettings = !showSettings">
              <i class="bi bi-three-dots"></i>
              <SettingsFolder v-model:show="showSettings"></SettingsFolder>
            </div>

            <BaseButton @click="setShowModalAddingPassword(true)" v-if="userAccess === 3">
              Добавить пароль
            </BaseButton>
          </div>
        </div>

        <div class="info-users" v-if="typeFolder === 'orgFolder'">
          <span v-if="dataCurrentSelectedFolder.users.length !== 0">
            Еще <span class="view-users" @click="showFolderUserAccessSettings = true">
            {{ dataCurrentSelectedFolder.users.length }} сотрудников</span> могут просматривать папку
          </span>

          <span v-if="dataCurrentSelectedFolder.users.length === 0">
            <span>В папке отсутствуют пользователи</span>
          </span>

        </div>
      </div>

      <BaseModal :show="showModalAddingPassword">
        <AddingPasswordForm></AddingPasswordForm>
      </BaseModal>

      <!--    Форма переименования папки    -->
      <BaseModal :show="showModalRenameFolder">
        <RenameFolderForm :name-folder="dataCurrentSelectedFolder.name"></RenameFolderForm>
      </BaseModal>

      <!--    Подтверждение удаления папки    -->
      <BaseModal @closeModal="setShowModalConfirmDelete(false)" :show="showModalConfirmDelete">
        <ConfirmDeleteFolder
          :name-folder="dataCurrentSelectedFolder.name">
        </ConfirmDeleteFolder>
      </BaseModal>

      <!--    Список паролей    -->
      <div class="open-login-container">
        <!--    Список паролей текущей папки    -->
        <LoginList @openLogin="showOpenLogin" :logins="dataCurrentSelectedFolder.logins"
                   :width-value="loginListWidth"></LoginList>
        <!--   Отобразить выбранный пароль   -->
        <SelectedLogin @close="closeLoginView" :show="showSelectedLogin"></SelectedLogin>
      </div>

      <BaseModal @closeModal="setShowInviteFolder(false)" :show="showInviteFolder">
        <!--    Пригласить в папку    -->
        <InviteToFolder></InviteToFolder>
      </BaseModal>

      <BaseModal @closeModal="showFolderUserAccessSettings = false" :show="showFolderUserAccessSettings">
        <FolderUserAccessSettings @closeModal="showFolderUserAccessSettings = false" :folder-name="dataCurrentSelectedFolder.name"
                                  :users="dataCurrentSelectedFolder.user_data" :owner="dataCurrentSelectedFolder.owner">
        </FolderUserAccessSettings>
      </BaseModal>
    </div>
  </div>
</template>

<script>
import {mapGetters, mapMutations, mapState} from "vuex";
import LoginList from "@/components/Login/LoginList";
import SettingsFolder from "@/components/Folder/SettingsFolder";
import ConfirmDeleteFolder from "@/components/Folder/ConfirmDeleteFolder";
import RenameFolderForm from "@/components/Folder/RenameFolderForm";
import AddingPasswordForm from "@/components/Folder/AddingPasswordForm";
import SelectedLogin from "@/components/Login/SelectedLogin";
import InviteToFolder from "@/components/Folder/InviteToFolder";
import FolderUserAccessSettings from "@/components/Folder/FolderUserAccessSettings";

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
    FolderUserAccessSettings,
  },

  data() {
    return {
      showSettings: false,
      showFolderUserAccessSettings: false,
      loginListWidth: 80,
    }
  },

  created() {
    this.setPasswordData();
  },

  watch: {
    selectedFolderId() {
      if (this.selectedFolderId !== null) {
        this.setStatusAccessFolder();
        this.closeLoginView();
      }
    },

    selectedOrgFolderId() {
      if (this.selectedOrgFolderId !== null) {
        this.setStatusAccessFolder();
        this.closeLoginView();
      }
    },

    showHeadLines() {
      if (this.showHeadLines === true) {
        return this.loginListWidth = 80;
      }
    },

    currentFolderLogins() {
      this.setPasswordData();
    },
  },

  computed: {
    ...mapState([
      'showModalConfirmDelete',
      'showModalAddingPassword',
      'showModalRenameFolder'
    ]),
    // login namespace
    ...mapState('login', ['showSelectedLogin', 'showHeadLines']),
    // user namespace
    ...mapState('auth', ['userData']),
    // folder namespace
    ...mapState('folder', [
      'dataCurrentSelectedFolder',
      'typeFolder',
      'selectedFolderId',
      'selectedOrgFolderId',
    ]),
    ...mapGetters('folder', ['getListFolderLogins']),
    // organization namespace
    ...mapState('organizationFolder', ['showInviteFolder', 'userAccess']),
  },

  methods: {
    ...mapMutations(['setShowModalConfirmDelete', 'setShowModalRenameFolder', 'setShowModalAddingPassword']),
    // login namespace
    ...mapMutations('login', ['setShowSelectedLogin']),
    // organization namespace
    ...mapMutations('organizationFolder', ['setShowInviteFolder', 'setUserAccess']),

    // установить данные текущей папки
    setPasswordData() {
      if (this.typeFolder === 'orgFolder') {
        this.setStatusAccessFolder();
      } else if (this.typeFolder === 'userFolder') {
        this.setStatusAccessFolder();
      }
    },

    // установка доступа пользователя к папке
    setStatusAccessFolder() {
      if (this.typeFolder === 'userFolder') {
        return this.setUserAccess(3);
      }

      // если пользователь владелец папки, установить "3" доступ
      if (this.dataCurrentSelectedFolder.user_id === this.userData.id) {
        this.setUserAccess(3);
      } else {
        // установка назначенного доступа
        this.setUserAccess(parseInt(this.dataCurrentSelectedFolder?.access));
      }
    },

    closeFormRenameFolder() {
      this.setShowModalRenameFolder(false);
    },

    showOpenLogin() {
      this.setShowSelectedLogin(true)
      this.loginListWidth = 55; // ширина при просмотре
    },

    closeLoginView() {
      this.setShowSelectedLogin(false);
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
    word-break: break-all;
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
