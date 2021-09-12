<template>
    <div class="card text-dark bg-light mb-3 ml-3" style="max-width: 18rem;">
        <div class="card-header" data-toggle="tooltip" data-placement="top" :title="title">Name: {{ fullName }}</div>
        <div class="card-body">
            <h5 class="card-title">Sport: {{ user.sport.name }}</h5>
            <p class="card-text">Created at: {{ user.created_at }}</p>
            <p class="card-text">Settlement: {{ user.settlement.name }}</p>
                <div class="row ml-1">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" :id="user.id"
                               :value="user.id" @change="toggleMember(user.id)">
                        <!--                                       :checked="selected_user !== null && role.id === selected_user.role_id"-->
                        <label class="custom-control-label" :for="user.id">In team</label>
                    </div>
                </div>
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
        title:{
          required: false,
          type: String,
        },
        user: {
          required: false,
          type: Object,
        },
        members: {
          required: false,
          type: Array,
        }},
    methods: {
        toggleMember(member) {
            if (!this.members.includes(member)) {
              this.members.push(member);
            } else {
              this.members.splice(this.members.indexOf(member), 1);
            }
        },
    },
    computed:{
        fullName() {
            let name = this.user.full_name;
            if (name.length > 20) {
                this.title = name;
                return name.substr(0, 20) + '...';
            }
            return name;
        }
    }
}
</script>

<style scoped>

</style>