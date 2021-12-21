<template>
    <div>
        <div v-if="team.ex_members.length > 0">
            <h3>{{ team.name }}, Created {{ createdBefore() }} by {{ team.created_by.full_name }}</h3>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="mb-3" v-for="(exMember, id) in team.ex_members" :key="id">
                        <ul class="list-group">
                            <li class="list-group-item active bg-primary">Name: {{ exMember.full_name }}</li>
                            <li class="list-group-item">Joined at: {{ exMember.history.joined_at }}
                                at position {{ exMember.history.current_role }}
                            </li>
                            <li class="list-group-item">Left at: {{ exMember.history.left_at }}</li>
                            <li class="list-group-item">Left before: {{ leftBefore(exMember.history.left_at) }}</li>
                            <li class="list-group-item">Days spent in the team: {{
                                    timeSpent(exMember.history.joined_at, exMember.history.left_at)
                                }}
                            </li>
                        </ul>
                        <span v-if="id != last">
                        <hr>
                    </span>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <div class="row justify-content-center text-center alert-info">This team do not have left members history
            </div>
        </div>
    </div>
</template>

<script>
import {differenceInDays, format, formatDistance, subDays} from "date-fns";

export default {
    name: "TeamHistory",
    props: {
        team: {
            required: true,
            type: Object | Array,
        },
    },
    methods: {
        timeSpent(from, to) {
            return differenceInDays(new Date(to), new Date(from));
        },
        createdBefore() {
            let distance = formatDistance(subDays(new Date(), this.timeSpent(new Date(), this.team.created_at)), new Date(), {addSuffix: true});

            return distance + ' at ' + format(new Date(this.team.created_at), 'MM-dd-yyyy');
        },
        leftBefore(leftAt) {
            return formatDistance(subDays(new Date(), this.timeSpent(new Date(), leftAt)), new Date(), {addSuffix: true});
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
