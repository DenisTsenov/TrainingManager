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
					<div class="list-group-item" v-for="(role, index) in roles" :key="role.id">
						<button class="btn rounded"
								:class="{'btn-success' : roleId === role.id, 'btn-primary': roleId !== role.id}"
								type="button" @click="fillPermissions(role.id, index)">
							{{ role.name }}
						</button>
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
					<div class="list-group-item" v-for="(permission, index) in permissionsData" :key="permission.id">
						<div class="custom-control custom-switch my-1 mr-sm-2">
							<input type="checkbox" :disabled="!roleId" class="custom-control-input" :id="permission.name"
								   :checked="permission.checked === true" @change="assignPermission(permission, index)">
							<label class="custom-control-label"
								   :for="permission.name">
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
                permissionsData: [],
                loading: true,
                roleId: false,
            }
        },
        mounted() {
            this.getRoles();
            this.getPermissions();
        },
        methods: {
            getRoles() {
                axios.get('/admin/role/manage-role', {}).then(response => {
                    this.roles = response.data.roles;
                }).catch(error => {

                });
            },
            getPermissions() {
                axios.get('/admin/permission/manage-permission', {}).then(response => {
                    response.data.permissions.forEach(function (permission) {
                        permission.checked = false;
                    });
                    this.permissionsData = response.data.permissions;
                    this.loading         = false;
                }).catch(error => {

                });
            },
            fillPermissions(roleId, index) {
                if (!this.roles[index] || this.roleId === this.roles[index].id) return;
                this.clearPermissions();
                this.roleId         = this.roles[index].id;
                let permissionsData = this.$data.permissionsData;
                let rolePermissions = _.map(this.roles[index].permissions, 'id');

                rolePermissions.forEach(function (rolePermissionId) {
                    permissionsData.forEach(function (permissionData) {
                        if (rolePermissionId === permissionData.id) {
                            permissionData.checked = true;
                            return false;
                        }
                    });
                });
            },
            assignPermission(permission, index) {
                axios.post('/admin/role/assign-permission', {
                    role: this.roleId,
                    permission: permission.id,
                }).then(response => {
                    permission.checked === false ? permission.checked = true : permission.checked = false;

                    let assignFlag = true;
                    let self = this; // in order to delete role permission if uncheck role

                    this.roles[this.roleId - 1].permissions.forEach(function (rolePermission, id) {
                        if (rolePermission.id === permission.id) {
                            Vue.delete(self.roles[self.roleId - 1].permissions, id);
                            assignFlag        = false;
                            return false;
                        }
                    })

                    if (assignFlag) {
                        this.roles[this.roleId - 1].permissions.push(permission)
                    }
                }).catch(error => {
                    console.log(error)
                });
            },
            clearPermissions() {
                this.permissionsData.forEach(function (permissionData) {
                    permissionData.checked = false;
                });
            },
        }
    }
</script>

<style scoped>

</style>
