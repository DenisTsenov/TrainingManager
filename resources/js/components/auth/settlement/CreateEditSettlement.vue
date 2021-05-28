<template>
  <div class="row justify-content-center mt-3">
    <div class="col-6">
      <div class="card">
        <div class="card-header">
          <p class="h3 text-center">{{ actionType }} settlement</p>
        </div>
        <div class="card-body">
          <form class="form" @submit.prevent="create">
            <div class="form-group">
              <label for="settlement">Name</label>
              <input type="text" id="settlement" v-model="settlement" name="settlement" class="form-control">
              <div v-if="hasBeenSend && !$v.settlement.required" class="alert alert-danger mt-3">
                Settlement field is required.
              </div>
              <div v-if="hasBeenSend && !$v.settlement.minLength" class="alert alert-danger mt-3">
                The name must be at least 2 characters.
              </div>
              <div v-if="hasBeenSend && !$v.settlement.maxLength" class="alert alert-danger mt-3">
                The name may not be greater than 50 characters.
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
      <div v-if="success" class="alert alert-success mt-3">
        Operation pass successfully
      </div>
      <div v-if="serverErr" class="alert alert-danger">Something went wrong. Please try again later..</div>
    </div>
  </div>
</template>

<script>
import CreateEditSettlementMixin from "../../../mixin/CreateEditSettlementMixin";

export default {
  mixins: [CreateEditSettlementMixin],
  name: 'CreateEditSettlement',
  data() {
    return {}
  },
}

</script>

<style scoped>

</style>
