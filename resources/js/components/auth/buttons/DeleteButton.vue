<template>
  <button :class="classes" @click="click(data)" title="Toggle">
        <span>
            <i class="fa fa-trash" aria-hidden="true"></i>
        </span>
    &nbsp;
    {{ name }}
  </button>
</template>

<script>
export default {
  name: "DeleteButton",
  props: {
    data: {},
    name: {},
    click: {
      type: Function,
      default: () => {
      }
    },
    classes: {
      type: Object,
      default: () => ({
        'btn': true,
        'btn-warning': true,
        'btn-sm': true,
      }),
    },
  }
}
</script>

<style scoped>

</style>
