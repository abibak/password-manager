<template>
    <p class="folder">{{this.folder.name}}</p>
</template>

<script>
export default {
  name: "FolderItem",

  props: {
    folder: {
      type: Object,
      required: true,
    }
  },
}
</script>

<style lang="scss" scoped>

.folder {
  margin-top: 8px;
  cursor: pointer;

  &:hover {
    opacity: .8;
  }
}

</style>
