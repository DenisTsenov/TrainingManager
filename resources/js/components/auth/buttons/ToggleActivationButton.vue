<template>
    <button :class="classes" @click="click(data)" v-bind:title="title">
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
            title: 'Deactivate'
        }
    },
    props: {
        data: {},
        name: {},
        click: {
            type: Function,
            default: () => {
            }
        },
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
        }
    },
    created() {
        this.resolveActive();
    }
}
</script>

<style scoped>

</style>
