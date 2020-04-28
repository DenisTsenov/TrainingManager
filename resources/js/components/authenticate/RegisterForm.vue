<template>
	<div class="row justify-content-center mt-3">
		<div class="col-6">
			<p class="h3 text-center"> Create your account</p>
			<form class="form">
				<div class="form-group">
					<label for="first_name">First name</label>
					<input type="text" class="form-control" name="first_name" id="first_name"/>
				</div>

				<div class="form-group">
					<label for="last_name">Last name</label>
					<input type="text" class="form-control" name="last_name" id="last_name"/>
				</div>

				<div class="form-group">
					<label for="email">E-mail</label>
					<input type="email" class="form-control" name="email" id="email"/>
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" id="password"/>
				</div>

				<div class="form-group">
					<label for="confirm_password">Confirm Password</label>
					<input type="password" class="form-control" name="confirm_password" id="confirm_password"/>
				</div>
				<div class="form-group text-center">
					<button type="submit" class="btn btn-primary w-50">Register</button>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
    export default {
        name: "RegisterForm"
    }
</script>

<style scoped>

</style>