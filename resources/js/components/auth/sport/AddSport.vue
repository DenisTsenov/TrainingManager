<template>
  <div class="row justify-content-center mt-3">
    <div class="col-6">
      <div class="card">
        <div class="card-header">
          <p class="h3 text-center">Create sport</p>
        </div>
        <div class="card-body">
          <form class="form" @submit.prevent="create">
            <div class="form-group">
              <label for="sport">Name</label>
              <input type="text" id="sport" v-model="sport" name="sport" class="form-control">
              <div v-if="hasBeenSend && !$v.sport.required" class="alert alert-danger mt-3">
                Settlement is required.
              </div>
              <div v-if="hasBeenSend && !$v.sport.minLength" class="alert alert-danger mt-3">
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
      <div v-if="success" class="alert alert-success mt-3">
        The sport is created successfully
      </div>
      <div v-if="serverErr" class="alert alert-danger">Something went wrong. Please try again later..</div>
    </div>
  </div>
</template>

<script>
import AddSportMixin from "../../../mixin/AddSportMixin";

export default {
  mixins: [AddSportMixin],
  name: 'AddSport',
  data() {
    return {}
  },
}

</script>

<style scoped>

</style>
