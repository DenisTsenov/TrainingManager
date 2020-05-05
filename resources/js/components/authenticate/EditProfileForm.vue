<template>
	<div class="row justify-content-center mt-3">
		<div class="col-6">
			<p class="h3 text-center">Edit your account</p>
			<form class="form" @submit.prevent="submit">
				<div class="form-group">
					<label for="first_name">First name</label>
					<input type="text" class="form-control" name="first_name" id="first_name"
						   v-model="userData.first_name"/>
					<div v-if="submitted && !$v.userData.first_name.required" class="text-danger">
						First name is required
					</div>
					<div v-if="errors && errors.first_name" class="text-danger">{{ errors.first_name[0] }}</div>
				</div>

				<div class="form-group">
					<label for="last_name">Last name</label>
					<input type="text" class="form-control" name="last_name" id="last_name"
						   v-model="userData.last_name"/>
					<div v-if="submitted && !$v.userData.last_name.required" class="text-danger">
						Last Name is required
					</div>
					<div v-if="errors && errors.last_name" class="text-danger">{{ errors.last_name[0] }}</div>
				</div>

				<div class="form-group">
					<label for="email">E-mail</label>
					<input type="email" class="form-control" name="email" id="email"
						   v-model="userData.email"/>
					<div v-if="submitted && $v.userData.email.$error" class="text-danger">
						<span v-if="!$v.userData.email.required">Email is required</span>
						<span v-if="!$v.userData.email.email">Email is invalid</span>
					</div>
					<div v-if="errors && errors.email" class="text-danger">{{ errors.email[0] }}</div>
				</div>

				<div class="form-group">
					<label for="password">New password</label>
					<input type="password" class="form-control" name="password" id="password"
						   v-model="userData.password"/>
					<div v-if="submitted && $v.userData.password.$error" class="text-danger">
						<span v-if="!$v.userData.password.required">Password is required</span>
						<span v-if="!$v.userData.password.minLength">Password must be at least 8 characters</span>
					</div>
					<div v-if="errors && errors.password" class="text-danger">{{ errors.password[0] }}</div>
				</div>

				<div class="form-group">
					<label for="password_confirmation">Confirm new password</label>
					<input type="password" class="form-control" name="password_confirmation"
						   v-model="userData.password_confirmation" id="password_confirmation"/>
					<div v-if="submitted && $v.userData.password_confirmation.$error" class="text-danger">
						<span v-if="!$v.userData.password_confirmation.required">Password is required</span>
						<span v-if="!$v.userData.password_confirmation.sameAsPassword">Passwords must match</span>
					</div>
					<div v-if="errors && errors.password_confirmation" class="text-danger">
						{{errors.password_confirmation[0] }}
					</div>
				</div>
				<div class="form-group text-center">
					<button type="submit" class="btn btn-primary w-50">Edit</button>
				</div>
				<div v-if="success" class="alert alert-success mt-3">
					The profile is edited successfully
				</div>
			</form>
		</div>
	</div>
</template>

<script>
    import EditMixin from "../../mixin/EditMixin";

    export default {
        mixins: [EditMixin],

        data() {
            return {
                'action': '/profile/' + this.user.id,
            }
        }
    }
</script>

<style scoped>

</style>
