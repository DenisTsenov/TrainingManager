<template>
	<div>
		<div class="row">
			<div class="col-8 offset-2">
				<div class="input-group mt-3">
					<input type="text" class="form-control" placeholder="User Name or email" aria-label="User Name..."
						   aria-describedby="User Name or email" v-model="searched_users.identifier"
						   @keyup="findUser" name="identifier" autocomplete="off">
					<div class="input-group-append">
						<span class="input-group-text" id="basic-addon2">User name/Email</span>
					</div>
				</div>
				<div class="list-group" v-if="results.length > 0 && searched_users.identifier.length">
					<a class="list-group-item list-group-item-action list-group-item-info"
					   v-for="result in results.slice(0,5)" :key="result.id">
						<div v-text="result.full_name"></div>
					</a>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-8 offset-2 mt-5">
				<div class="card">
					<div class="card-header">
						<p class="h3 text-center">Roles</p>
					</div>
					<fieldset disabled>
						<div class="card-body">
							<roles-checkboxes :roles="roles"></roles-checkboxes>
						</div>
					</fieldset>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
    import RolesCheckboxes from "../authenticate/admin/RolesCheckboxes";

    export default {
        name: "SearchField",
        components: {
            RolesCheckboxes
        },
        data() {
            return {
                searched_users: {
                    identifier: '',
                    roles: {},
                },
                results: []
            }
        },
        watch: {
            searched_users(after, before) {
                this.findUser();
            }
        },
        props: {
            roles: {},
        },
        methods: {
            findUser() {
                if (this.searched_users.identifier.length > 1) {
                    axios.post('/admin/find-user/' + this.searched_users.identifier, {identifier: this.searched_users.identifier})
                         .then(response => {
                             this.results = response.data;
                         })
                         .catch(error => {

                         });
                }
            }
        }
    }
</script>

<style scoped>

</style>
