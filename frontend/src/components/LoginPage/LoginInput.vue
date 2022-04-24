<template>
  <input
    class="input-login"
    :type="typeInput"
    :value="modelValue"
    :style="{boxShadow: error}"
    @input="updateValue">
</template>

<script>

export default {
  name: "LoginInput",

  props: {
    modelValue: [String, Number],
    typeInput: {
      type: String,
      required: true,
    }
  },

  data() {
    return {
      error: '',
    }
  },

  methods: {
    updateValue(event) {
      this.$emit('update:modelValue', event.target.value);
    },
  }
}

</script>

<style lang="scss" scoped>
.input-login {
  width: auto;
  padding: 8px 8px;
  color: #000;
  border: 1px solid #fff;
  border-radius: 10px;
  outline: none;
  line-height: normal;
  background-color: #fff;
  transition: box-shadow .2s;

  &:focus {
    box-shadow: 0 0 0 3px rgba(38, 131, 224, .7);
  }
}
</style>
