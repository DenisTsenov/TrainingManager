<template>
    <div>
        <data-table
            :columns="columns"
            url="http://trainingmanager.test/admin/sport/list">
        </data-table>
        <div v-if="error" class="warning">
            Something went wrong! Please tray again later.
        </div>
    </div>
</template>
<script>

import EditButton from "../../buttons/EditButton";
import ToggleActivationButton from "../../buttons/ToggleActivationButton";

export default {
    name: "SportList",
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
                    label: 'In settlements',
                    name: 'settlements_count',
                    orderable: true,
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
                    handler: this.editSport,
                    component: EditButton,
                },
                {
                    label: '',
                    orderable: false,
                    event: "click",
                    component: ToggleActivationButton,
                },
            ],
            error: false,
        }
    },
    components: {
        EditButton,
        ToggleActivationButton,
    },
    methods: {
        editSport(data) {
            window.location = 'sport/edit/' + data.id
        },
    },
    props: {
        route: ''
    }
}
</script>

<style scoped>

</style>
