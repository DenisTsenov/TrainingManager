<template>
	<div>
		<button type="button" class="navbar-brand btn btn-light text-muted" v-on:click="logout">Logout</button>
		<span class="badge badge-danger" v-if="serverErr">Something went wrong</span>
	</div>
</template>

<script>
    export default {
        data() {
            return {
                serverErr: false,
                loaded: true,
            }
        },
        methods: {
            logout: function (event) {
                if (this.loaded) {
                    this.loaded = false;
                    axios.post('/logout', {}).then(
                        response => {
                            window.location = response.data.route;
                        }
                    ).catch(error => {
                        if (error.length) {
                            this.serverErr = true;
                        }
                    });
                }
            }
        }
    }
</script>

<style scoped>

</style>
