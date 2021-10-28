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
import RedirectButton from "../buttons/RedirectButton";

export default {
    name: "TeamsList",
    data() {
        return {
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: false,
                    width: 4,
                },
                {
                    label: 'Name',
                    name: 'name',
                    orderable: true,
                    width: 8,
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
                    width: 8,
                },
                {
                    label: 'Settlement',
                    name: 'settlement.name',
                    columnName: 'settlements.name',
                    orderable: true,
                    width: 9,
                },
                {
                    label: 'Members',
                    name: 'members_count',
                    orderable: true,
                    width: 8,
                },
                {
                    label: 'Created at',
                    name: 'created_at',
                    orderable: true,
                    width: 11,
                },
                {
                    label: 'Actions',
                    name: 'Edit',
                    orderable: false,
                    classes: {
                        'btn': true,
                        'btn-success': true,
                        'btn-sm': true,
                    },
                    event: "click",
                    handler: this.editTeam,
                    component: EditButton,
                    width: 4,
                },
                {
                  label: '',
                  name: 'History',
                  orderable: false,
                  classes: {
                    'btn': true,
                    'btn-warning': true,
                    'btn-sm': true,
                  },
                  handler: this.teamHistory,
                  component: RedirectButton,
                  width: 6,
                },
            ],
        }
    },
    components: {
        EditButton, RedirectButton,
    },
    methods: {
        editTeam(data) {
            window.location = 'team/edit/' + data.id
        },
        teamHistory(data) {
            window.location = 'team/history/' + data.id
        },
    },
}
</script>

<style scoped>

</style>
