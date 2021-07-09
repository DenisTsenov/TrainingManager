<template>
    <div>
        <a class="btn btn-success btn-xl mb-3 text-white" :href="route">New team</a>
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
                },
                {
                    label: 'Name',
                    name: 'name',
                    orderable: true,
                },
                {
                    label: 'Trainer',
                    name: 'trainer.full_name',
                    columnName: 'users.full_name',
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
    props:{
        route: ''
    }
}
</script>

<style scoped>

</style>
