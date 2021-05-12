<template>
    <button :class="classes" @click="click(data)" title="Approve">
        <span>
            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
        </span>
        &nbsp;
        {{ name }}
    </button>
</template>

<script>
export default {
    name: "ApproveButton",
    props: {
        data: {},
        name: {},
        click: {
            type: Function,
            default: () => {}
        },
        classes: {
            type: Object,
            default: () => ({
                'btn': true,
                'btn-primary': true,
                'btn-sm': true,
            }),
        },
    }
}
</script>

<style scoped>

</style>
