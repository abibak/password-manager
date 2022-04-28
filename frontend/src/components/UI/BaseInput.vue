<template>
  <input :type="type" class="base-input" @input="updateValue" :value="modelValue" autocomplete="off">
</template>

<script>
export default {
  name: "BaseInput",

  props: {
    modelValue: {
      type: String,
    },

    type: {
      type: String,
    },
  },

  methods: {
    updateValue(event) {
      this.$emit('update:modelValue', event.target.value);
    },
  }
}
</script>

<style lang="scss" scoped>

.base-input {
  display: block;
  outline: none;
  border: none;
  line-height: 40px;
  background-color: transparent;
  border-bottom: 1px solid #a3a3a3;
  transition: border-bottom-color $transTime;

  &:focus {
    border-bottom-color: $baseColor;
  }
}

</style>
