<template>
	<div class="row justify-content-center mt-3">
		<div class="col-6">
			<p class="h3 text-center">Sign In</p>
			<form class="form" @submit.prevent="submit">
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

				<div class="form-group text-center">
					<button type="submit" class="btn btn-primary w-50">Sign in</button>
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
                'action': '/login',
                'login': true,
            }
        }
    }
</script>

<style scoped>

</style>
