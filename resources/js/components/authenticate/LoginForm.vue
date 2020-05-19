<template>
	<div class="row justify-content-center mt-3">
		<div class="col-6">
			<div class="card">
				<div class="card-header">
					<p class="h3 text-center">Sign In</p>
				</div>
				<div class="card-body">
					<form class="form" @submit.prevent="submit">
						<div class="form-group">
							<label for="email">E-mail</label>
							<input type="email" class="form-control" name="email" id="email" v-model="userData.email"/>
							<div v-if="submitted && $v.userData.email.$error" class="alert alert-danger mt-3">
								<span v-if="!$v.userData.email.required">Email is required.</span>
								<span v-if="!$v.userData.email.email">Email is invalid.</span>
							</div>
							<div v-if="errors && errors.email" class="alert alert-danger mt-3">{{ errors.email[0] }}
							</div>
						</div>

						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" name="password" id="password"
								   v-model="userData.password"/>
							<div v-if="submitted && $v.userData.password.$error" class="alert alert-danger mt-3">
								<span v-if="!$v.userData.password.required">Password is required.</span>
								<span v-if="!$v.userData.password.minLength">Password must be at least 8 characters.</span>
							</div>
							<div v-if="errors && errors.password" class="alert alert-danger mt-3">{{ errors.password[0]
								}}
							</div>
						</div>

						<div class="form-group text-center">
							<button type="submit" class="btn btn-primary w-50">Sign in</button>
						</div>
					</form>
					<div v-if="serverErr" class="alert alert-danger">Something went wrong. Please try again later</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
    import LoginMixin from "../../mixin/LoginMixin";

    export default {
        mixins: [LoginMixin],
        name: 'LoginForm',
        data() {
            return {
                'action': '/login',
            }
        }
    }
</script>

<style scoped>

</style>
