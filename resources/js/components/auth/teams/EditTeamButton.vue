<template>
    <button :class="classes" @click="click(data)" title="Edit">
        <span>
            <i class="fa fa-edit" aria-hidden="true"></i>
        </span>
        &nbsp;
        {{ name }}
    </button>
</template>

<script>
export default {
    name: "EditTeamButton",
    props: {
        data: {},
        name: {},
        click: {
            type: Function,
            default: () => {
            }
        },
        classes: {
            type: Object,
            default: () => ({
                'btn': true,
                'btn-success': true,
                'btn-sm': true,
            }),
        },
    }
}
</script>

<style scoped>

</style>
