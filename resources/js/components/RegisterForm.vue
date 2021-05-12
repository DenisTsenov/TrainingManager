<template>
    <div class="row justify-content-center mt-3">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <p class="h3 text-center">Create your account</p>
                </div>
                <div class="card-body">
                    <form class="form" @submit.prevent="submit">
                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                   v-model="userData.first_name"/>
                            <div v-if="hasBeenSend && !$v.userData.first_name.required" class="alert alert-danger mt-3">
                                First name is required.
                            </div>
                            <div v-if="errors && errors.first_name" class="alert alert-danger mt-3">
                                {{ errors.first_name[0] }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                   v-model="userData.last_name"/>
                            <div v-if="hasBeenSend && !$v.userData.last_name.required" class="alert alert-danger mt-3">
                                Last Name is required.
                            </div>
                            <div v-if="errors && errors.last_name" class="alert alert-danger mt-3">
                                {{ errors.last_name[0] }}
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
                            <select name="settlement_id" id="settlement" class="form-control"
                                    @change='getSports($event, settlement)'
                                    v-model="settlement">
                                <option v-for="(settlement, id) in settlements" :value="id" :key="id">{{ settlement }}
                                </option>
                            </select>
                            <div v-if="hasBeenSend && !$v.userData.settlement_id.required"
                                 class="alert alert-danger mt-3">
                                Settlement is required.
                            </div>
                            <div v-if="errors && errors.settlement_id" class="alert alert-danger mt-3">
                                {{ errors.settlement_id[0] }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sport">Sport</label>
                            <select name="sport_id" id="sport" class="form-control" v-model="sport" @change="setSport($event, sport)">
                                <option v-if="!settlementSelected" value="0" selected="selected">
                                    select settlement first...
                                </option>
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
            <div v-if="serverErr" class="alert alert-danger">Something went wrong. Please try again
                later..
            </div>
            <div v-if="success" class="alert alert-success mt-3">
                The profile is created successfully
            </div>
        </div>
    </div>
</template>

<script>
import RegisterMixin from "../mixin/RegisterMixin";

export default {
    mixins: [RegisterMixin],
    name: 'RegisterForm',
    data() {
        return {}
    },
}
</script>

<style scoped>

</style>
