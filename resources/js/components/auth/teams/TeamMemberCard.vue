<template>
    <div>
        <div class="card text-dark bg-light mb-3 ml-3" style="max-width: 18rem;" v-for="user in usersComputed">
            <div class="card-header" data-toggle="tooltip" data-placement="top" :title="tooltipTitle">Name: {{
                user.full_name
                }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Sport: {{ user.sport.name }}</h5>
                <p class="card-text">Created at: {{ user.created_at }}</p>
                <p class="card-text">Settlement: {{ user.settlement.name }}</p>
                <div class="row ml-1">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" :id="user.id" @change="toggle(user.id)">
                        <!--                                       :checked="selected_user !== null && role.id === selected_user.role_id"-->
                        <label class="custom-control-label" :for="user.id">In team</label>
                    </div>
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
        title: {
            required: false,
            type: String,
        },
        users: {
            required: false,
            type: Array|Object,
        },
        user: {
            required: false,
            type: Array|Object,
        },
        members: {
            required: false,
            type: Array,
        }
    },
    methods: {
        toggle(member) {
            if (!this.members.includes(member)) {
                this.members.push(member);
            } else {
                this.members.splice(this.members.indexOf(member), 1);
            }
        },
    },
    computed: {
        // fullName() {
        //     let name = this.user.full_name;
        //     if (name.length > 15) {
        //         this.title = name;
        //         return name.substr(0, 15) + '...';
        //     }
        //     return name;
        // },
        // tooltipTitle() {
        //     if (this.user.full_name.length > 15) {
        //         return this.title = this.user.full_name;
        //     }
        //     return this.title = '';
        // },
        usersComputed() {
            return this.users;
        }
    },
    // created(){
    //     console.log(this.userss);
    // }
}
</script>

<style scoped>

</style>
