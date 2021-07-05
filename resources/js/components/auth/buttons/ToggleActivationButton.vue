<template>
    <button :class="classes" @click="toggleActivation()" :title="title">
        <span>
            <i class="fa fa-trash" aria-hidden="true"></i>
            {{ this.title }}
        </span>
        &nbsp;
        {{ name }}
    </button>
</template>

<script>
export default {
    name: "ToggleActivationButton",
    data() {
        return {
            classes: {
                'btn': true,
                'btn-danger': true,
                'btn-sm': true,
            },
            title: 'Deactivate',
        }
    },
    props: {
        data: {},
        name: {},
    },
    methods: {
        resolveActive() {
            if (this.data.deleted_at != null) {
                this.title   = 'Activate';
                this.classes = {
                    'btn': true,
                    'btn-warning': true,
                    'btn-sm': true,
                }
            }
        },
        toggleActivation() {
          axios.post('sport/toggle-activation/' + this.data.id, {'sport': this.data})
               .then(response => {
                   if (response.data.deleted){
                       this.title = 'Activate';
                       this.classes = {
                         'btn': true,
                         'btn-warning': true,
                         'btn-sm': true,
                       };
                       return;
                   }

                 this.title = 'Deactivate';
                 this.classes = {
                   'btn': true,
                   'btn-danger': true,
                   'btn-sm': true,
                 };
               })
               .catch(error => {
                 if (error.response.status === 422) {
                   this.error = true;
                 }
               });
        }
    },
    created() {
        this.resolveActive();
    }
}
</script>

<style scoped>

</style>
