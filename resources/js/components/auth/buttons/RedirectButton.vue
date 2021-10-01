<template>
    <button :class="classes" @click="click(data)" title="History">
          <span>
              <i class="fas fa-history" aria-hidden="true"></i>
          </span>
      &nbsp;
      {{ name }}
    </button>
</template>

<script>
export default {
    name: "RedirectButton",
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