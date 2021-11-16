<template>
    <div class="row ">
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <h5>Name: {{ user.full_name }}</h5>
                    <h5>Sport: {{ user.sport.name }}</h5>
                    <h5>Settlement: {{ user.settlement.name }}</h5>
                    <h5>Created at: {{ user.created_at }}</h5>
                    <h5>Waiting from: {{ timePassedSinceCreation(user.created_at) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-5">
            <form class="form" @submit.prevent="distribute">
                <div v-if="teams">
                    <div class="form-group">
                        <label for="team">Teams</label>
                        <select name="team_id" class="form-control" id="team" @change='showTeamData($event, team)'
                                v-model="team">
                            <option v-for="team in teams" :key="team.id" :value="team">
                                {{ team.name }}
                            </option>
                        </select>
                        <div v-if="errors && errors.team" class="alert alert-danger mt-3">
                            {{ errors.team[0] }}
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary w-50" :disabled="disabled">Send</button>
                    </div>
                </div>
                <div v-else>
                    <h3 class="text-center font-weight-bold">There is no team matching sport and settlement for this
                        user</h3>
                </div>
            </form>
        </div>
        <div v-if="viewTeamData" class="col-4">
            <div class="form-group text-center">
                <div>Name: {{ team.name }}</div>
                <div>Members count: {{ team.members_count }}</div>
                <div>Trainer: {{ team.trainer.full_name }}</div>
                <div>Created at: {{ team.created_at }}</div>
                <div>Created before: {{ timePassedSinceCreation(team.created_at) }}</div>
                <div>
                    <button type="submit" class="btn btn-primary w-50" @click="viewTeam(team.id)">View team</button>
                </div>
            </div>
        </div>
        <div v-if="serverErr" class="alert alert-danger">Something went wrong. Please try again later</div>
    </div>
</template>

<script>
import {differenceInCalendarDays} from "date-fns";
import {required} from "vuelidate/lib/validators";

export default {
    name: "DistributeUser",
    data() {
        return {
            team: {},
            errors: {},
            serverErr: false,
            disabled: true,
            viewTeamData: false,
        }
    },
    validations: {
        team: {
            required,
        }
    },
    props: {
        user: {
            required: true,
            type: Object,
        },
        teams: {
            required: false,
            type: Object | null,
        },
    },
    methods: {
        showTeamData(e, teamId) {
            if (!teamId) {
                this.viewTeamData = false;
                this.disabled = true;
                return;
            }

            this.viewTeamData = true;
            this.disabled     = false;
        },
        timePassedSinceCreation(from) {
            let difference = differenceInCalendarDays(new Date(), new Date(from));

            if (difference == 1) {
                return difference + ' day';
            }

            return difference + ' days';
        },
        viewTeam(teamId) {
            return window.open(window.location.origin + '/admin/team/edit/' + teamId, '_blank');
        },
        distribute() {

        }
    },
    created() {

    }
}
</script>

<style scoped>

</style>
