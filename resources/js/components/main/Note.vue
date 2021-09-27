<template>
<span class="d-inline-block text-danger fa-pulse" tabindex="0" data-toggle="tooltip" :title="text">
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
          required: false,
          type: String,
          default: "Please, pay attention to trainer\'s settlement and sport. Once team is created, you will be able to see only (in edit functionality) trainers and members/users only for trainer\'s settlement and sport selected in this step."
      }
  }
}
</script>

<style scoped>

</style>