<template>
    <div>
        <data-table
            :columns="columns"
            url="http://trainingmanager.test/admin/team/list">
        </data-table>
    </div>
</template>

<script>
import EditButton from "../buttons/EditButton";

export default {
    name: "TeamsList",
    data() {
        return {
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: false,
                    width: 5,
                },
                {
                    label: 'Name',
                    name: 'name',
                    orderable: true,
                    width: 10,
                },
                {
                    label: 'Trainer',
                    name: 'trainer.full_name',
                    columnName: 'users.full_name',
                    orderable: true,
                    width: 10,
                },
                {
                    label: 'Sport',
                    name: 'sport.name',
                    columnName: 'sports.name',
                    orderable: true,
                    width: 10,
                },
                {
                    label: 'Settlement',
                    name: 'settlement.name',
                    columnName: 'settlements.name',
                    orderable: true,
                    width: 10,
                },
                {
                    label: 'Created at',
                    name: 'created_at',
                    orderable: true,
                    width: 10,
                },
                {
                    label: 'Actions',
                    name: '',
                    orderable: false,
                    classes: {
                        'btn': true,
                        'btn-success': true,
                        'btn-sm': true,
                    },
                    event: "click",
                    handler: this.editTeam,
                    component: EditButton,
                    width: 10,
                },
            ],
        }
    },
    components: {
        EditButton,
    },
    methods: {
        editTeam(data) {
            window.location = 'team/edit/' + data.id
        },
    },
}
</script>

<style scoped>

</style>
