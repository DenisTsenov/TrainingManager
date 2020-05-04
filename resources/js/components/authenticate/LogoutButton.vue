<template>
	<button type="button" class="navbar-brand btn btn-light text-muted" v-on:click="logout">Logout</button>
</template>

<script>
    export default {
        data() {
        },
        methods: {
            logout: function (event) {
                axios.post('/logout', {}).then(
                    response => {
                        window.location = response.data.route;
                    }
                ).catch(error => {
                    if (error.length) {
                        alert('Something went wrong...');
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
