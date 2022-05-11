<template>
  <BaseNotification @closeBaseNotification="errorNotification = false" v-model:show="errorNotification">
  </BaseNotification>

  <BaseModal @closeModal="setShowTopSettingsMenu(false)" :show="showTopSettingsMenu">
    <TopSettingsMenu></TopSettingsMenu>
  </BaseModal>

  <div class="site-main" :style="{ transform: this.mainScale }">
    <div class="header-main">
      <div class="icon-menu" @click="setShowTopSettingsMenu(true)">
        <i class="bi bi-list"></i>
      </div>

      <div class="block-app-naming">
        <span class="app-name">Password Manager</span>
        <span class="vertical-line"></span>
      </div>

      <div class="block-info-user">
        <i class="bi bi-bell"></i>
        <span class="user-login">{{ userData.login }}</span>
        <span class="avatar-user">{{ getFirstLetterNameUser }}</span>
      </div>
    </div>

    <div class="main-section">
      <div class="container-main">
        <div class="left-section">
          <LeftSettingsMenu v-if="openGeneralSettings === true"></LeftSettingsMenu>

          <div class="container-left-section" v-if="openGeneralSettings === false">
            <div class="search-panel">
              <form>
                <input type="text" placeholder="Поиск" class="search">
              </form>

              <i class="bi bi-search"></i>
            </div>

            <div class="section-organization">
              <div class="info-org-section">
                <p>Раздел организации</p>
                <i class="bi bi-plus-circle" v-if="userData.is_admin" @click="showFormCreateOrgFolder = true"></i>

                <BaseModal @closeModal="closeFormCreateFolder" v-bind:show="showFormCreateOrgFolder">
                  <CreateFolderForm @closeForm="closeFormCreateFolder" :type-folder="`orgFolder`"></CreateFolderForm>
                </BaseModal>
              </div>

              <div class="organization-folders">
                <FolderList :folders="this.dataOrganizationFolders.data" :type-folder="`orgFolder`"></FolderList>
              </div>
            </div>

            <div class="section-user">
              <div class="info-section-user">
                <p>Личный раздел</p>
                <i class="bi bi-plus-circle" @click="showFormCreateFolder = true"></i>

                <BaseModal @closeModal="closeFormCreateFolder" v-bind:show="showFormCreateFolder">
                  <CreateFolderForm @closeForm="closeFormCreateFolder" :type-folder="`userFolder`"></CreateFolderForm>
                </BaseModal>
              </div>

              <div class="user-folders">
                <!-- Список пользовательских папок -->
                <FolderList :folders="this.dataFolders.data" :type-folder="`userFolder`"></FolderList>
              </div>

              <div class="favorite-passwords">
                <i class="bi bi-star"></i>
                <span>Избранные пароли</span>
              </div>
            </div>
          </div>
        </div>

        <div class="right-folder-section">
          <SettingsAccount v-if="showSettingsAccount"></SettingsAccount>
          <ListUsers v-if="showSettingsManageUsers"></ListUsers>
          <!-- Отображение секции с открытой папкой -->
          <SelectedFolderSection v-if="this.showSectionSelectedFolder"></SelectedFolderSection>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapMutations, mapState } from "vuex";
import FolderList from "@/components/Folder/FolderList";
import CreateFolderForm from "@/components/Folder/CreateFolderForm";
import BaseModal from "@/components/UI/BaseModal";
import SelectedFolderSection from "@/components/SelectedFolderSection";
import TopSettingsMenu from "@/components/TopSettingsMenu";
import LeftSettingsMenu from "@/components/LeftSettingsMenu";
import SettingsAccount from "@/components/Settings/SettingsAccount";
import ListUsers from "@/components/Settings/ManageUsers/ListUsers";

export default {
  name: "Main",
  components: {
    FolderList,
    CreateFolderForm,
    BaseModal,
    SelectedFolderSection,
    TopSettingsMenu,
    LeftSettingsMenu,
    SettingsAccount,
    ListUsers,
  },

  data() {
    return {
      errorNotification: false,
      showFormCreateOrgFolder: false,
      showFormCreateFolder: false,
      mainScale: '',
    }
  },

  created() {
    this.sendRequestGetFolders();
    this.sendRequestGetOrganizationFolders();
  },

  watch: {
    errors() {
      if (this.errors !== null) {
        this.errorNotification = true;
      }
    },

    showTopSettingsMenu() {
      if (this.showTopSettingsMenu) {
        return this.mainScale = 'scale(.98)';
      }
      return this.mainScale = '';
    },
  },

  computed: {
    ...mapState('auth', ['userData']),
    ...mapState('folder', ['dataFolders', 'showSectionSelectedFolder', 'dataOrganizationFolders']),
    ...mapState('settings', ['showSettingsAccount', 'showSettingsManageUsers']),
    ...mapState([
      'errors',
      'showSectionSelectedFolder',
      'showTopSettingsMenu',
      'openGeneralSettings',
      'showModalAddingFolder',
    ]),

    getFirstLetterNameUser() {
      return typeof this.userData.login === 'string' ? this.userData.login.charAt(0).toUpperCase() : '';
    }
  },

  methods: {
    ...mapActions('folder', ['sendRequestGetFolders', 'sendRequestGetOrganizationFolders',]),
    ...mapMutations(['setShowTopSettingsMenu', 'setShowModalAddingFolder']),

    closeFormCreateFolder() {
      this.showFormCreateOrgFolder = false;
      this.showFormCreateFolder = false;
    },
  },
}
</script>

<style lang="scss" scoped>
.site-main {
  margin: auto;
  width: 92%;
  font-size: 18px;
  padding: 15px 15px;
  transition: transform .35s;
  position: relative;

  .header-main {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 15px;
    position: relative;

    .icon-menu {
      font-size: 26px;
      position: absolute;
      cursor: pointer;
    }

    .block-app-naming {
      display: flex;
      align-items: center;
      margin-left: 35px;

      .vertical-line {
        width: 1px;
        height: 25px;
        margin-left: 15px;
        opacity: 1;
        background-color: #fff;
        animation-name: animationLine;
        animation-duration: .5s;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in-out;
        animation-direction: alternate-reverse;

        @keyframes animationLine {
          0% {
            opacity: 0;
          }

          100% {
            opacity: 1;
          }
        }
      }
    }

    .app-name {
      font-weight: bold;
      letter-spacing: .1em;
      font-size: 26px;
    }

    .block-info-user {
      display: flex;
      align-items: center;

      .bi-bell {
        font-size: 26px;
        cursor: pointer;
        transition: color $transTime;

        &:hover {
          color: #a3a3a3;
        }
      }

      .avatar-user,
      .user-login {
        margin-left: 12px;
      }

      .avatar-user {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        color: #2683E0;
        background-color: #fff;
        border-radius: 50%;
        font-size: 20px;
      }
    }
  }

  .main-section {
    width: 100%;
    background-color: #fff;
    margin-top: 15px;
    padding: 0 0 0 25px;
    font-weight: 500;
    border-radius: 10px;
    color: #948383;

    .container-main {
      display: flex;

      .left-section {
        width: 25%;
        min-height: 800px;
        padding: 25px 25px 25px 0;
        border-right: 1px solid #a3a3a3;
        overflow-x: hidden;
        transition: opacity $transTime;

        .search-panel {
          display: flex;
          align-items: center;
          border-bottom: 1px solid #a3a3a3;

          form {
            width: 100%;

            .search {
              width: 100%;
              padding: 5px 0 5px 28px;
              outline: none;
              border: none;
              color: #A3A3A3;
              font-weight: 400;

              &::placeholder {
                transition: all $transTime;
              }

              &:focus::placeholder {
                padding: 8px;
                transform: scale(.95);
                opacity: 0;
              }
            }
          }

          .bi-search {
            position: absolute;
            color: #000;
          }
        }

        .section-organization {
          padding: 15px 0;
          border-bottom: 1px solid #a3a3a3;
        }

        .section-organization,
        .section-user {

          .info-org-section,
          .info-section-user p:first-child {
            color: #000;
          }
        }

        .section-user,
        .favorite-passwords {
          padding-top: 15px;

          .user-folders {
            padding-bottom: 15px;
            border-bottom: 1px solid #a3a3a3;
          }

          .favorite-passwords {
            span {
              padding-left: 5px;
              cursor: pointer;
              transform: color, $transTime;

              &:hover {
                color: #a3a3a3;
              }
            }
          }
        }

        .info-org-section,
        .info-section-user {
          display: flex;
          justify-content: space-between;

          .bi-plus-circle {
            color: #a3a3a3;
            font-size: 22px;
            cursor: pointer;
            transition: opacity $transTime;

            &:hover {
              opacity: .8;
            }
          }
        }
      }

      .right-folder-section {
        width: 75%;
      }
    }
  }
}
</style>
