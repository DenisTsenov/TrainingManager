<template>
    <div class="row justify-content-center mt-3">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <p class="h3 text-center">Edit your account</p>
                </div>
                <!-- Need to refactor in order this form to be used here and in RegisterFrom component -->
                <div class="card-body">
                    <form class="form" @submit.prevent="submit">
                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                   v-model="userData.first_name"/>
                            <div v-if="hasBeenSend && !$v.userData.first_name.required" class="alert alert-danger mt-3">
                                First name is required.
                            </div>
                            <div v-if="errors && errors.first_name" class="alert alert-danger mt-3">{{
                                    errors.first_name[0]
                                }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                   v-model="userData.last_name"/>
                            <div v-if="hasBeenSend && !$v.userData.last_name.required" class="alert alert-danger mt-3">
                                Last Name is required.
                            </div>
                            <div v-if="errors && errors.last_name" class="alert alert-danger mt-3">{{
                                    errors.last_name[0]
                                }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" name="email" id="email" v-model="userData.email"/>
                            <div v-if="hasBeenSend && $v.userData.email.$error" class="alert alert-danger mt-3">
                                <span v-if="!$v.userData.email.required">Email is required.</span>
                                <span v-if="!$v.userData.email.email">Email is invalid format.</span>
                            </div>
                            <div v-if="errors && errors.email" class="alert alert-danger mt-3">{{ errors.email[0] }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="settlement">Settlement</label>
                            <span class="badge badge-warning" v-if="this.isInTeam">
                              This option is not editable if you are in a team
                            </span>
                            <select name="settlement_id" id="settlement" class="form-control"
                                    :disabled="this.isInTeam"
                                    @change='setSettlement(settlement)'
                                    v-model="settlement">
                                <option v-for="(settlement, id) in settlements" :value="id" :key="id">
                                    {{ settlement }}
                                </option>
                            </select>
                            <div v-if="errors && errors.settlement_id" class="alert alert-danger mt-3">
                                {{ errors.settlement_id[0] }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sport">Sport</label>
                            <span class="badge badge-warning" v-if="this.isInTeam">
                              This option is not editable if you are in a team
                            </span>
                            <select name="sport_id" id="sport" class="form-control"
                                    :disabled="this.isInTeam"
                                    @change="setSport($event, sport)"
                                    v-model="sport">
                                <option v-for="(sport, id) in sports" :value="id" :key="id">{{ sport }}</option>
                            </select>
                            <div v-if="hasBeenSend && !$v.userData.sport_id.required" class="alert alert-danger mt-3">
                                Sport is required.
                            </div>
                            <div v-if="errors && errors.sport_id" class="alert alert-danger mt-3">
                                {{ errors.sport_id[0] }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                   v-model="userData.password"/>
                            <div v-if="hasBeenSend && $v.userData.password.$error" class="alert alert-danger mt-3">
                                <span v-if="!$v.userData.password.required">Password is required.</span>
                                <span
                                    v-if="!$v.userData.password.minLength">Password must be at least 8 characters.</span>
                            </div>
                            <div v-if="errors && errors.password" class="alert alert-danger mt-3">{{
                                    errors.password[0]
                                }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm password</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                   v-model="userData.password_confirmation" id="password_confirmation"/>
                            <div v-if="hasBeenSend && $v.userData.password_confirmation.$error"
                                 class="alert alert-danger mt-3">
                                <span
                                    v-if="!$v.userData.password_confirmation.required">Confirm password is required.</span>
                                <span
                                    v-if="!$v.userData.password_confirmation.sameAsPassword">Passwords must match.</span>
                            </div>
                            <div v-if="errors && errors.password_confirmation" class="alert alert-danger mt-3">
                                {{ errors.password_confirmation[0] }}
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary w-50">Send</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="form-group text-center mt-3">
                <disable-profile-button :destroy-route="destroyRoute"></disable-profile-button>
            </div>
            <div v-if="serverErr" class="alert alert-danger">Something went wrong. Please try again
                later..
            </div>
            <div v-if="success" class="alert alert-success mt-3">
                The profile is edited successfully
            </div>
        </div>
    </div>
</template>

<script>
import EditMixin from "../../mixin/EditMixin";
import DisableProfileButton from "./buttons/DisableProfileButton";

export default {
    mixins: [EditMixin],
    components: {DisableProfileButton},
    name: 'EditForm',
    data() {
        return {}
    }
}
</script>

<style scoped>

</style>
