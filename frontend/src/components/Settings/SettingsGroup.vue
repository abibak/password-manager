<template>
  <SettingsAccount v-show="showSettingsAccount"></SettingsAccount>
  <SettingsAuthorization v-show="setShowSettingsAuthorization"></SettingsAuthorization>
  <ListUsers v-show="showSettingsManageUsers"></ListUsers>
</template>

<script>
import {mapState} from "vuex";
import SettingsAccount from "@/components/Settings/SettingsAccount";
import SettingsAuthorization from "@/components/Settings/SettingsAuthorization";
import ListUsers from "@/components/Settings/ManageUser/ListUsers";

export default {
  name: "SettingsGroup",
  components: {
    SettingsAccount,
    SettingsAuthorization,
    ListUsers,
  },

  props: {
  },

  data() {
    return {
    }
  },

  computed: {
    ...mapState('settings', ['setShowSettingsAuthorization', 'showSettingsManageUsers', 'showSettingsAccount'])
  },
}
</script>

<style lang="scss" scoped>

</style>
