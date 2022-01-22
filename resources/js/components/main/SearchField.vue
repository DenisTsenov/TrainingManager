<template>
    <div>
        <div class="row">
            <div class="col-8 offset-2 mt-3">
                <vue-select label="full_name" :filterable="false" :options="options" @search="onSearch"
                            v-model="selected_user">
                    <template slot="no-options">
                        Type user name or email address...
                    </template>
                    <template slot="option" slot-scope="option">
                        <div>
                            {{ option.full_name }}
                        </div>
                    </template>
                    <template slot="selected-option" slot-scope="option">
                        <div>
                            {{ option.full_name }}
                        </div>
                    </template>
                </vue-select>
            </div>
        </div>
        <div class="row">
            <div class="col-8 offset-2 mt-5">
                <div class="card">
                    <div class="card-header">
                        <p class="h3 text-center">Roles</p>
                    </div>
                    <fieldset :disabled="selected_user === null || selected_user === '' ">
                        <div class="card-body">
                            <roles-checkboxes :roles="roles" :selected_user="selected_user"></roles-checkboxes>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RolesCheckboxes from "../auth/admin/RolesCheckboxes";

export default {
    name: "SearchField",
    components: {
        RolesCheckboxes
    },
    data() {
        return {
            options: [],
            selected_user: '',
        }
    },
    props: {
        roles: {},
    },
    methods: {
        onSearch(search, loading) {
            loading(true);
            this.search(loading, search, this);
        },
        search: _.debounce((loading, search, vm) => {
            axios.get('/admin/find-user', {
                params: {
                    term: escape(search)
                }
            }).then(response => {
                vm.options = response.data;
                loading(false);
            }).catch(error => {
                loading(false);
            });
        }, 350),
    }
}
</script>

<style scoped>

</style>
