<template>
	<div class="input-group">
		<div v-for="role in roles" :key="role.id">
			<div class="custom-control custom-switch my-1 mr-sm-2">
				<input type="checkbox" class="custom-control-input" :id="role.id"
					   :name="name + '[' + role.id + ']' " :value="role.id" :checked="role.id == selected_user.role_id">
				<label class="custom-control-label" :for="role.id">{{ role.name }}</label>
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
    }
</script>

<style scoped>

</style>