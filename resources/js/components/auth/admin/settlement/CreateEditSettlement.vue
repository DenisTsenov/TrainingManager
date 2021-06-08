<template>
    <div>
        <form class="form" @submit.prevent="create">
            <div class="row justify-content-center mt-3">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <p class="h3 text-center">{{ actionType }} settlement</p>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="settlement">Name</label>
                                <input type="text" id="settlement" v-model="settlement" name="settlement"
                                       class="form-control">
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
                                <button type="submit" class="btn btn-primary w-50">{{ actionType }}</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <p class="h3 text-center">Sports</p>
                        </div>
                        <div class="card-body">
                            <div class="form-inline">
                                <div v-for="(sport, id) in sports" :key="id">
                                    <div class="form-check ml-5">
                                        <input type="checkbox"
                                               class="form-check-input"
                                               v-model="sport.checked"
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
        <div v-if="serverErr" class="alert alert-danger">Something went wrong. Please try again later..</div>
    </div>
</template>

<script>
import CreateEditSettlementMixin from "../../../../mixin/CreateEditSettlementMixin";

export default {
    mixins: [CreateEditSettlementMixin],
    name: 'CreateEditSettlement',
    data() {
        return {}
    },
}
</script>

<style scoped></style>
