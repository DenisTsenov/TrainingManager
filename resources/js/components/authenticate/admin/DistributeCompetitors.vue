<template>
    <data-table
        :columns="columns"
        url="http://trainingmanager.test/distribution">
    </data-table>
</template>

<script>
export default {
    name: "DistributeCompetitor",
    data() {
        return {
            columns: [
                {
                    label: 'ID',
                    name: 'id',
                    orderable: true,
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
                    orderable: false,
                },
                {
                    label: 'Settlement',
                    name: 'settlement.name',
                    orderable: false,
                },
            ]
        }
    },
}
</script>

<style scoped>

</style>
