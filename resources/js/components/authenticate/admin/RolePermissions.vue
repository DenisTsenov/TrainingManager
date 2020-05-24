<template>
	<div v-if="loading" class="row mt-5">
		<div class="col-12 text-center mt-5">
			<loading></loading>
		</div>
	</div>
	<div class="row mt-5" v-else>
		<div class="col-lg-6 col-md-12">
			<div class="card border-primary mb-3" style="max-width: 18rem;">
				<div class="card-header">Roles</div>
				<div class="card-body text-primary">
					<h5 class="card-title">When role is selected the permission will be accordingly changed.</h5>
					<hr>
					<div class="list-group-item" v-for="role in roles" :key="role.id">
						<button class="btn bt-primary rounded">{{ role.name }}</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-12">
			<div class="card border-primary mb-3" style="max-width: 18rem;">
				<div class="card-header">Permissions</div>
				<div class="card-body text-primary">
					<h5 class="card-title">Choose the permissions for the selected role.</h5>
					<hr>
					<div class="list-group-item" v-for="permission in permissions" :key="permission.id">
						<div class="custom-control custom-switch my-1 mr-sm-2">
							<input type="checkbox" class="custom-control-input"
								   :id="permission.name.toLowerCase().replace(' ', '_')">
							<label class="custom-control-label"
								   :for="permission.name.toLowerCase().replace(' ', '_')">
								{{ permission.name }}
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        name: "RolePermissions",
        data: function () {
            return {
                roles: [],
                permissions: [],
                loading: true,
            }
        },
        mounted() {
            this.getRoles();
            this.getPermissions();
        },
        methods: {
            getRoles() {
                axios.get('/admin/manage-role', {}).then(response => {
                    this.roles = response.data.roles;
                }).catch(error => {

                });
            },
            getPermissions() {
                axios.get('/admin/manage-permission', {}).then(response => {
                    this.permissions = response.data.permissions;
                    this.loading     = false;
                }).catch(error => {

                });
            }
        }
    }
</script>

<style scoped>

</style>
