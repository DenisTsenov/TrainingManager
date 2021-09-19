<template>
  <div>
      <form class="form" @submit.prevent="send">
          <div class="row justify-content-center mt-3">
              <div class="col-6">
                  <div class="card">
                      <div class="card-header">
                          <p class="h3 text-center">{{ actionType }} team</p>
                      </div>
                      <div class="card-body">
                          <div class="form-group">
                              <label for="name">Team name</label>
                              <input type="text" class="form-control" name="name" id="name"
                                     v-model="name"/>
                              <div v-if="hasBeenSend && !$v.name.required" class="alert alert-danger mt-3">
                                  The name field is required.
                              </div>
                              <div v-if="hasBeenSend && !$v.name.minLength" class="alert alert-danger mt-3">
                                  The name must be at least 2 characters.
                              </div>
                              <div v-if="errors && errors.name" class="alert alert-danger mt-3">
                                  {{ errors.name[0] }}
                              </div>
                          </div>

                          <div class="form-group">
                              <label :for="trainer">Trainer</label>
                              <select name="trainer_id" id="trainer" class="form-control"
                                      @change='getUsers($event, trainer)'
                                      v-model="trainer">
                                  <option v-for="trainer in trainers" :key="trainer.id" :value="trainer.id">
                                      {{
                                      trainer.full_name + ' (' + trainer.sport.name + '/' + trainer.settlement.name + ')'
                                      }}
                                  </option>
                              </select>
                              <div v-if="hasBeenSend && !$v.trainer.required" class="alert alert-danger mt-3">
                                  Trainer field is required.
                              </div>
                              <div v-if="errors && errors.trainer" class="alert alert-danger mt-3">
                                  {{ errors.trainer[0] }}
                              </div>
                          </div>

                          <div class="form-group text-center">
                              <button type="submit" class="btn btn-primary w-50">Send</button>
                          </div>

                          <div class="form-group text-center" v-if="actionType == 'Create'">
                              <span class="d-inline-block text-danger fa-pulse" tabindex="0" data-toggle="tooltip"
                                    title="Please, pay attention to trainer's settlement and sport. Once team is created, you will be able to see only (in edit functionality) trainers and members/users only for trainer's settlement and sport selected in this step.">
                                  <span>
                                    <i class="fas fa-exclamation-circle fa-lg"></i>
                                  </span>
                              </span>
                          </div>
                      </div>
                  </div>
                  <div v-if="serverErr" class="alert alert-danger">Something went wrong. Please try again later..</div>
              </div>
          </div>
          <div class="row justify-content-center mt-3 mb-3">
              <div class="col-12">
                  <div class="card">
                      <div class="card-header bg-primary">
                          <p class="h3 text-center">Members/Users</p>
                      </div>
                      <div class="card-body scroll-h-400-px">
                          <div class="form-inline" v-if="users !== {}">
                              <team-member-card :members="members" :users="users" :team="team" :distribution="distribution">
                              </team-member-card>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </form>
      <div class="form-group text-center" v-if="actionType == 'Edit'">
          <remove-team-button :team="team" :destroy-route="destroyRoute" :can-destroy="canDestroy"></remove-team-button>
      </div>
  </div>
</template>

<script>
import CreateEditMixin from "../../../mixin/CreateEditMixin";
import TeamMemberCard from "./TeamMemberCard";
import RemoveTeamButton from "./RemoveTeamButton";

export default {
    mixins: [CreateEditMixin],
    components: {TeamMemberCard, RemoveTeamButton},
    name: 'CreateEditTeam',
    data() {
        return {}
    }
}
</script>

<style scoped>

</style>
