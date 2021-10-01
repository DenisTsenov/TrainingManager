<template>
<span :class="baseStyle" tabindex="0" data-toggle="tooltip" :title="text">
    <span>
        <i class="fas fa-exclamation-circle fa-lg"></i>
    </span>
</span>
</template>

<script>
export default {
    name: "Note",
    data() {
        return {}
    },
  props: {
      text: {
          required: true,
          type: String,
      },
      baseStyle: {
          required: false,
          type: Object,
          default: 'd-inline-block text-danger fa-pulse',
      }
  }
}
</script>

<style scoped>

</style>