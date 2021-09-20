<template>
    <div class="row" v-if="computedDistribution">
        <div class="card text-dark bg-light mb-3 ml-5" style="max-width: 18rem;" v-for="user in computedUsers">
            <div class="card-header" data-toggle="tooltip" data-placement="top" :title="tooltipTitle(user.full_name)">
                Name: {{ userName(user.full_name) }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Sport: {{ user.sport.name }}</h5>
                <p class="card-text">Created at: {{ user.created_at }}</p>
                <p class="card-text">Settlement: {{ user.settlement.name }}</p>
                <div class="row ml-1">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" :id="user.id" @change="toggle(user.id)"
                               :checked="team !== null && team.id === user.team_id">
                        <label class="custom-control-label" :for="user.id">In team</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <div v-else>
      <div class="alert alert-primary text-center" role="alert">
        There are no users waiting for distribution or without team.
      </div>
  </div>
</template>

<script>
export default {
    name: "team-member-card",
    data() {
        return {}
    },
    props: {
        title: {
            required: false,
            type: String,
        },
        users: {
            required: false,
            type: Array | Object,
        },
        members: {
            required: false,
            type: Array,
        },
        team: {
            required: false,
            type: Object,
            default: false,
        },
        distribution: {
            required: false,
            type: Boolean,
            default: true
        },
    },
    methods: {
        toggle(member) {
            if (!this.members.includes(member)) {
                this.members.push(member);
            } else {
                this.members.splice(this.members.indexOf(member), 1);
            }
        },
        userName(name) {
            return name.length > 15 ? name.substr(0, 15) + '...' : name;
        },
        tooltipTitle(name) {
            return name.length > 15 ? name : '';
        },
    },
    computed: {
        computedUsers() {
            return this.users;
        },
        computedDistribution(){
            return this.distribution;
        }
    },
}
</script>

<style scoped>

</style>
