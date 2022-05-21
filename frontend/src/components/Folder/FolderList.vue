<template>
  <div class="block-folder" v-for="(item) of folders" :key="item.id">
    <FolderItem :folder="item" :type-folder="typeFolder"></FolderItem>
  </div>
</template>

<script>
import FolderItem from "@/components/Folder/FolderItem";

export default {
  name: "FoldersList",

  components: {
    FolderItem,
  },

  props: {
    folders: {
      type: Object
    },

    typeFolder: {
      type: String,
      required: true,
    }
  }
}
</script>

<style lang="scss" scoped>
.block-folder {
  margin-top: 5px;
}
</style>
