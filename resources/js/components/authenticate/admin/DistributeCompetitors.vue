<template>
    <data-table
        :columns="columns"
        url="http://trainingmanager.test/for-distribution">
    </data-table>
</template>

<script>
import ApproveButton from "../../main/ApproveButton";

export default {
    name: "DistributeCompetitor",
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
                    handler: this.showTeams,
                    component: ApproveButton,
                },
            ],
        }
    },
    components: {
        ApproveButton,
    },
    methods: {
        showTeams(data) {
            alert(`You clicked row ${data.id}`);
        },
    },
}
</script>

<style scoped>

</style>
