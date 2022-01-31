<template>
    <div v-if="this.destroyRoute">
        <vue-confirm-dialog></vue-confirm-dialog>
        <button class="btn btn-danger w-50" @click="confirmDisable()">
            Disable profile
            <i class="far fa-trash-alt"></i>
        </button>
    </div>
    <div v-else>
        <button class="btn btn-danger w-50" tabindex="0" data-toggle="tooltip"
                title="You are still in a team." disabled>
            Disable profile
            <i class="far fa-trash-alt"></i>
        </button>
    </div>
</template>

<script>
export default {
    name: 'DisableProfileButton',
    props: {
        destroyRoute: {
            required: true,
            type: URL | null,
        },
    },
    methods: {
        confirmDisable() {
            this.$confirm({
                title: `Delete profile`,
                message: `Are you sure you want to disable your profile?`,
                button: {
                    no: 'Cancel',
                    yes: 'Ok'
                },
                /**
                 * Callback Function
                 * @param {Boolean} confirm
                 */
                callback: confirm => {

                    if (confirm) {
                        axios.post(this.destroyRoute)
                             .then(response => {
                                 window.location = response.data.login;
                             }).catch(error => {
                            alert('Something went wrong! Please try again later')
                        });
                    }
                }
            });
        }
    },
}
</script>

<style scoped>

</style>
