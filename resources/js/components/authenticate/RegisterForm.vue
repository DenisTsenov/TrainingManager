<template>
	<div class="row justify-content-center mt-3">
		<div class="col-6">
			<p class="h3 text-center"> Create your account</p>
			<form class="form" @submit.prevent="submit">
				<div class="form-group">
					<label for="first_name">First name</label>
					<input type="text" class="form-control" name="first_name" id="first_name"
						   v-model="fields.first_name"/>
					<div v-if="errors && errors.first_name" class="text-danger">{{ errors.first_name[0] }}</div>
				</div>

				<div class="form-group">
					<label for="last_name">Last name</label>
					<input type="text" class="form-control" name="last_name" id="last_name" v-model="fields.last_name"/>
					<div v-if="errors && errors.last_name" class="text-danger">{{ errors.last_name[0] }}</div>
				</div>

				<div class="form-group">
					<label for="email">E-mail</label>
					<input type="email" class="form-control" name="email" id="email" v-model="fields.email"/>
					<div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" id="password"
						   v-model="fields.password"/>
					<div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>
				</div>

				<div class="form-group">
					<label for="password_confirmation">Confirm Password</label>
					<input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
						   v-model="fields.password_confirmation"/>
					<div v-if="errors && errors.password_confirmation" class="text-danger">{{
						errors.password_confirmation[0] }}
					</div>
				</div>
				<div class="form-group text-center">
					<button type="submit" class="btn btn-primary w-50">Register</button>
				</div>
				<div v-if="success" class="alert alert-success mt-3">
					The profile is created successfully
				</div>
			</form>
		</div>
	</div>
</template>

<script>
    import FormMixin from "../../mixin/FormMixin";
    export default {
        mixins: [FormMixin],

        data() {
            return {
                'action': '/store',
            }
        }
    }
</script>

<style scoped>

</style>
