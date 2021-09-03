<template>
    <data-table
        :columns="columns"
        url="http://trainingmanager.test/admin/for-distribution">
    </data-table>
</template>

<script>
import ReviewUserButton from "../../main/ReviewUserButton";

export default {
    name: "DistributeUsersList",
    data() {
        return {
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: false,
                },
                {
                    label: 'First name',
                    name: 'first_name',
                    orderable: true,
                },
                {
                    label: 'Last name',
                    name: 'last_name',
                    orderable: true,
                },
                {
                    label: 'Email',
                    name: 'email',
                    orderable: true,
                },
                {
                    label: 'Sport',
                    name: 'sport.name',
                    columnName: 'sports.name',
                    orderable: true,
                },
                {
                    label: 'Settlement',
                    name: 'settlement.name',
                    columnName: 'settlements.name',
                    orderable: true,
                },
                {
                    label: 'Created at',
                    name: 'created_at',
                    orderable: true,
                },
                {
                    label: '',
                    name: '',
                    orderable: false,
                    classes: {
                        'btn': true,
                        'btn-primary': true,
                        'btn-sm': true,
                    },
                    event: "click",
                    handler: this.showUser,
                    component: ReviewUserButton,
                },
            ],
        }
    },
    components: {
        ReviewUserButton,
    },
    methods: {
        showUser(data) {
            window.location = `admin/distribute-user/create/${data.id}`
        },
    },
}
</script>

<style scoped>

</style>
