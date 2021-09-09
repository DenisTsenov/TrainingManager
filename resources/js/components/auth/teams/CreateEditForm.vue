<template>
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
                                    @change='getCompetitors($event, trainer)'
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
                    </div>
                </div>
                <div v-if="serverErr" class="alert alert-danger">Something went wrong. Please try again later..</div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary">
                        <p class="h3 text-center">Members</p>
                    </div>
                    <div class="card-body">
                        <div class="form-inline">
                            <div v-for="(sport, id) in sports" :key="id">
                                <div class="form-check ml-5">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           v-model="sport.checked"
                                           :disabled="sport.deleted_at != null"
                                           :id="sport.name">
                                    <label class="form-check-label" :for="sport.name">{{ sport.name }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import CreateEditMixin from "../../../mixin/CreateEditMixin";

export default {
    mixins: [CreateEditMixin],
    name: 'CreateEditForm',
    data() {
        return {}
    }
}
</script>

<style scoped>

</style>
