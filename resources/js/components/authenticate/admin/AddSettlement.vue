<template>
  <div class="row justify-content-center mt-3">
    <div class="col-6">
      <div class="card">
        <div class="card-header">
          <p class="h3 text-center">Create settlement</p>
        </div>
        <div class="card-body">
          <form class="form" @submit.prevent="create">
            <div class="form-group">
              <label for="settlement"></label>
              <input type="text" id="settlement" v-model="settlement" name="settlement" class="form-control">
              <div v-if="hasBeenSend && !$v.settlement.required" class="alert alert-danger mt-3">
                Settlement is required.
              </div>
              <div v-if="hasBeenSend && !$v.settlement.minLength" class="alert alert-danger mt-3">
                Must have at least 2 letters.
              </div>
              <div v-if="errors && errors.name" class="alert alert-danger mt-3">
                {{ errors.name[0] }}
              </div>
            </div>
            <div class="form-group text-center">
              <button type="submit" class="btn btn-primary w-50">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AddSettlement from "../../../mixin/AddSettlement";

export default {
  mixins: [AddSettlement],
  name: 'AddSettlement',
  data() {
    return {}
  },
}

</script>

<style scoped>

</style>
