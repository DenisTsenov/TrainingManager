<template>
    <div>
        <h3>{{ user.full_name }}, ({{ user.sport.name + '/' + user.settlement.name}})</h3>
        <div v-if="user.membership_history.length > 0">
            <div class="row">
                <div class="col-12">
                    <div v-for="(team, id) in user.membership_history" :key="id">
                        <ul class="list-group">
                            <li class="list-group-item active">Team: {{ team.name }}</li>
                            <li class="list-group-item">Joined at: {{ team.pivot.joined_at }}</li>
                            <li class="list-group-item">Left at: {{ team.pivot.left_at != null ? team.pivot.left_at : 'Still in team' }}</li>
                          <li class="list-group-item">Left before: {{ leftBefore(team.pivot.left_at) }}</li>
                            <li class="list-group-item">Days spent in the team: {{ timeSpent(team.pivot.joined_at, team.pivot.left_at) }}</li>
                        </ul>
                      <div v-if="id != last">
                          <hr>
                      </div>
                    </div>
              </div>
            </div>
        </div>
        <div v-else>
            <div class="row justify-content-center text-center alert-info">You do not have any team membership history</div>
        </div>
    </div>
</template>

<script>
import {differenceInCalendarDays, formatDistance, subDays} from 'date-fns';
export default {
    name: "MembershipHistory",
    data() {
        return {}
    },
    props:{
        user: {
            required: true,
            type: Object,
        }
    },
    methods: {
        timeSpent(from, to) {
            if (to == null) to = new Date();
            return differenceInCalendarDays(new Date(to), new Date(from),);
        },
        leftBefore(leftAt) {
            if (leftAt == null){
                return 'Still in team';
            }
            return formatDistance(subDays(new Date(), this.timeSpent(leftAt)), new Date(), {addSuffix: true});
        }
    },
    computed:{
        last() {
            return Object.keys(this.user.membership_history).length - 1;
        }
    },
}
</script>

<style scoped>

</style>