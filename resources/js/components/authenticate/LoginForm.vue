<template>
	<div class="row justify-content-center mt-3">
		<div class="col-6">
			<p class="h3 text-center">Sign In</p>
			<form class="form">
				<div class="form-group">
					<label for="email">E-mail</label>
					<input type="email" class="form-control" name="email" id="email"/>
				</div>

				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" id="password"/>
				</div>

				<div class="form-group text-center">
					<button type="submit" class="btn btn-primary w-50">Sign in</button>
				</div>
			</form>
		</div>
	</div>
</template>

<script>
    export default {
        name: "LoginForm"
    }
</script>

<style scoped>

</style>