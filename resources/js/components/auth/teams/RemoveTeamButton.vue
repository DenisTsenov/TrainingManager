<template>
    <div v-if="canDestroy">
        <vue-confirm-dialog></vue-confirm-dialog>
        <button class="btn btn-danger w-50" @click="confirmRemove()">Remove team <i class="far fa-trash-alt"></i></button>
    </div>
    <div v-else>
        <button class="btn btn-danger w-50" tabindex="0" data-toggle="tooltip"
                title="There are members in this team or it is created before less than a day." disabled>Remove team <i class="far fa-trash-alt"></i></button>
    </div>
</template>

<script>
export default {
    name: 'RemoveTeamButton',
    props: {
        team: {
            required: true,
            type: Object,
        },
        destroyRoute:{
            required: false,
            type: String,
        },
        canDestroy: {
            required: false,
            type: Boolean|String,
        }
    },
    methods:{
        confirmRemove() {
            this.$confirm({
                title: `Remove team`,
                message: `Are you sure you want to delete team ` + `"` + this.team.name + `"` + `?`,
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
                               window.location = response.data.route;
                             }).catch(error => {
                          alert('Something went wrong! Please try again later');
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