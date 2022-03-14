<template>
  <div class="site-main">
    <div class="header-main">
      <div class="block-app-naming">
        <span class="app-name">Password Manager</span>
        <span class="vertical-line"></span>
      </div>

      <div class="block-info-user">
        <i class="bi bi-bell"></i>
        <span class="user-login">{{ this.userData().login }}</span>
        <span class="avatar-user">А</span>
      </div>
    </div>

    <div class="main-section">
      <div class="container-main">
        <div class="left-section">
          <div class="search-panel">
            <form>
              <input type="text" placeholder="Поиск" class="search">
            </form>

            <i class="bi bi-search"></i>
          </div>

          <div class="section-organization">
            <div class="info-org-section">
              <p>Раздел организации</p>
              <i class="bi bi-plus-circle"></i>
            </div>

            <div class="organization-folders">
              <p class="org-folder">Пароли компании</p>
              <p class="org-folder">Пользователи</p>
              <p class="org-folder">Клиенты</p>
              <p class="org-folder">IT</p>
            </div>
          </div>

          <div class="user-section">
            <div class="info-user-section">
              <p>Личный раздел</p>
              <i class="bi bi-plus-circle"></i>
            </div>

            <div class="user-folders">
              <p class="user-folder">Пароли компании</p>
              <p class="user-folder">Пользователи</p>
              <p class="user-folder">Клиенты</p>
              <p class="user-folder">IT</p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: "Main",

  data() {
    return {}
  },

  methods: {
    userData() {
      return Object.create(this.$store.state.auth.userData);
    },
  },
}
</script>

<style lang="scss" scoped>
.site-main {
  font-size: 18px;
  padding: 15px 15px;

  .header-main {
    display: flex;
    justify-content: space-between;
    padding: 0 15px;

    .block-app-naming {
      display: flex;
      align-items: center;

      .vertical-line {
        width: 1px;
        height: 60%;
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

      .avatar-user, .user-login {
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
    height: 100vh;
    background-color: #fff;
    margin-top: 15px;
    padding: 20px 20px;
    font-weight: 500;
    border-radius: 10px;
    color: #948383;

    .container-main {
      display: inline-block;

      .left-section {
        width: 300px;

        .search-panel {
          display: flex;
          align-items: center;
          position: relative;
          border-bottom: 1px solid #A3A3A3;

          form {
            width: 100%;

            .search {
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

        .section-organization, .user-section {
          padding: 15px 0;
          border-bottom: 1px solid #a3a3a3;

          .info-org-section, .info-user-section p:first-child {
            color: #000;
          }
        }

        .info-org-section, .info-user-section {
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

        .organization-folders, .user-folders {
          .org-folder, .user-folder {
            margin-top: 8px;
            cursor: pointer;

            &:hover {
              opacity: .8;
            }
          }
        }
      }

    }
  }

}
</style>
