<template>
    <button :class="classes" @click="toggleActivation()" :title="title">
        <span>
            <i :class="icon" aria-hidden="true"></i>
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
            icon: 'fa fa-trash',
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
                this.icon = 'fas fa-plug',
                this.classes = {
                    'btn': true,
                    'btn-primary': true,
                    'btn-sm': true,
                }
            }
        },
        toggleActivation() {
          axios.post('sport/toggle-activation/' + this.data.id, {'sport': this.data})
               .then(response => {
                   if (response.data.deleted){
                       this.title = 'Activate';
                       this.icon = 'fas fa-plug';
                       this.classes = {
                         'btn': true,
                         'btn-primary': true,
                         'btn-sm': true,
                       };
                       return;
                   }

                 this.title = 'Deactivate';
                 this.icon = 'fa fa-trash';
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
