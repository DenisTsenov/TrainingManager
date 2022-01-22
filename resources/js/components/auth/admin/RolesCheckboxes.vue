<template>
    <div class="input-group">
        <div v-if="loading">
            <div class="text-center">
                <loading></loading>
            </div>
        </div>
        <div class="row" v-if="loading === false">
            <div class="ml-3" v-for="role in roles" :key="role.id">
                <div class="custom-control custom-switch my-1 mr-sm-2">
                    <input type="checkbox" class="custom-control-input"
                           v-on:click="changeRole(role.id)"
                           :id="role.name.toLowerCase()"
                           :checked="selected_user !== null && role.id === selected_user.role_id"/>
                    <label class="custom-control-label" :for="role.name.toLowerCase()">{{ role.name }}</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "RolesCheckboxes",
    data() {
        return {
            name: 'role',
            loading: false,
        }
    },
    props: {
        roles: {
            type: Array,
            name: {
                type: String,
                required: true,
            },
            id: {
                type: Number,
                required: true,
            },
        },
        selected_user: {
            id: {
                type: Number,
            },
            full_name: {
                type: String,
            },
            role_id: {
                type: Number,
                required: true,
            },
        },
    },
    methods: {
        changeRole(role) {
            if (this.selected_user === null || !role) return;
            this.loading = true;
            axios.post('/admin/change-role/' + this.selected_user.id + '/' + role, {
                user: this.selected_user.id,
                role: role,
            }).then(response => {
                if (response.data == 'new role') {
                    this.selected_user.role_id = role;
                }

                if (response.data == 'no role') {
                    this.selected_user.role_id = 0;
                }

                this.loading = false;
            }).catch(error => {
                this.loading = false;
            });
        }
    }
}
</script>

<style scoped>

</style>
