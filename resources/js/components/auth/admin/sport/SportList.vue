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

import EditButton from "../../EditButton";
import DeleteButton from "../../buttons/DeleteButton";

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
                    name: 'Toggle',
                    orderable: false,
                    classes: {
                      'btn': true,
                      'btn-warning': true,
                      'btn-sm': true,
                    },
                    event: "click",
                    handler: this.deleteSport,
                    component: DeleteButton,
                },
            ],
          error: false
        }
    },
    components: {
        EditButton,
        DeleteButton,
    },
    methods: {
        editSport(data) {
            window.location = 'sport/edit/' + data.id
        },
        deleteSport(data) {
          this.error = false;
            axios.post('sport/toggle-disabled/' + data.id, {'sport': data})
                 .then(response => {
                   window.location = response.data.route;
                 })
                 .catch(error => {
                   if (error.response.status === 422) {
                      this.error = true;
                   }
                 });
        }
    },
    props: {
        route: ''
    }
}
</script>

<style scoped>

</style>
