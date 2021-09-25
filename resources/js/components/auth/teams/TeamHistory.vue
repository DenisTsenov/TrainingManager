<template>
<div>
    <div v-if="team.ex_members.length > 0">
        <h3>{{ team.name }}, Created {{ createdBefore() }} by {{ team.created_by.full_name }}</h3>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="mb-3" v-for="(exMember, id) in team.ex_members" :key="id">
                    <ul class="list-group">
                        <li class="list-group-item active bg-primary">Name: {{ exMember.full_name }}</li>
                        <li class="list-group-item">Joined at: {{ exMember.pivot.joined_at }}</li>
                        <li class="list-group-item">Left at: {{ exMember.pivot.left_at }}</li>
                        <li class="list-group-item">Left before: {{ leftBefore(exMember.pivot.left_at) }}</li>
                        <li class="list-group-item">Days spent in the team: {{ timeSpent(exMember.pivot.joined_at) }}</li>
                    </ul>
                    <span v-if="id != last">
                        <hr>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <div class="row justify-content-center text-center alert-info">This team do not have left members history</div>
    </div>
</div>
</template>

<script>
import {differenceInCalendarDays, formatDistance, subDays, format} from "date-fns";

export default {
    name: "TeamHistory",
    props: {
        team: {
            required: true,
            type: Object | Array,
        },
    },
    methods: {
        timeSpent(from) {
            return differenceInCalendarDays(new Date(), new Date(from),);
        },
        createdBefore() {
            let distance = formatDistance(subDays(new Date(), this.timeSpent(this.team.created_at)), new Date(), {addSuffix: true});

            return distance + ' at ' + format(new Date(this.team.created_at), 'MM-dd-yyyy');
        },
        leftBefore(leftAt) {
            return formatDistance(subDays(new Date(), this.timeSpent(leftAt)), new Date(), {addSuffix: true});
        }
    },
    computed: {
        last() {
            return Object.keys(this.team.ex_members).length - 1;
        },
    },
}
</script>

<style scoped>

</style>
