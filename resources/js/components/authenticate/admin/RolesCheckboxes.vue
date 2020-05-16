<template>
	<div class="input-group mt-5">
		<div v-for="role in roles" :key="role.id">
			<div class="form-check-inline">
				<label class="form-check-label mr-2"><span class="mr-2">{{ role.name}}</span>
				<input type="checkbox" class="form-check-inline" :value="role.id" >
				</label>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        name: "RolesCheckboxes",
        data() {
            return {}
        },
        props: {
            roles: Array,
        },
    }
</script>

<style scoped>

</style>