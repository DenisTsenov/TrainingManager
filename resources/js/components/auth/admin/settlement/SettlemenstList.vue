<template>
    <div>
        <data-table
            :columns="columns"
            url="http://trainingmanager.test/admin/settlement/list">
        </data-table>
    </div>
</template>
<script>

import EditButton from "../../EditButton";

export default {
    name: "SettlementList",
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
                    label: 'Created by',
                    name: 'created_by.full_name',
                    columnName: 'users.full_name',
                    orderable: true,
                },
                {
                    label: 'Created at',
                    name: 'created_at',
                    orderable: true,
                },
                {
                    label: 'Updated at',
                    name: 'updated_at',
                    orderable: true,
                },
                {
                    label: 'Sports count',
                    name: 'sports_count',
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
                    handler: this.editSettlement,
                    component: EditButton,
                },
            ],
        }
    },
    components: {
        EditButton,
    },
    methods: {
      editSettlement(data) {
            window.location = 'settlement/edit/' + data.id
        },
    },
    props:{
        route: ''
    }
}
</script>

<style scoped>

</style>
