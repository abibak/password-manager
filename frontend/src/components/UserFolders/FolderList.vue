<template>
  <div class="block-folder" v-for="(item) of folders" :key="item.id">
    <FolderItem :folder="item"></FolderItem>
  </div>
</template>

<script>
import FolderItem from "@/components/UserFolders/FolderItem";

export default {
  name: "FoldersList",

  components: {
    FolderItem,
  },

  props: ['folders']
}
</script>

<style scoped>

</style>
