<template>
  <input class="input" type="text" :value="innerValue" @input="updateValue($event.target.value)">
</template>

<script>
export default {
  name: "VTableInput",
  props: {
    value: { type: String, required: true }
  },
  data: () => ({
    innerValue: ''
  }),
  watch: {
    value:{
      immediate: true,
      handler (newValue, oldValue) {
        if (newValue !== undefined && newValue !== oldValue) this.innerValue = newValue
      }
    }
  },
  computed: {
    firstNameValid() {
      return /^[A-Za-z-_0-9]+$/.test(this.innerValue);
    }
  },
  methods: {
    isLetter(e) {
      let char = String.fromCharCode(e.keyCode);
      if (/^[A-Za-z]+$/.test(char)) return true;
      else e.preventDefault();
    },
    updateValue (value) {
      console.log(value)
      this.innerValue = value
      this.$emit('input', value)
    }
  }
};
</script>