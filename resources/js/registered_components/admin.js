import RolesCheckboxes from "../components/auth/admin/RolesCheckboxes";
import RolePermissions from "../components/auth/admin/RolePermissions";
import CreateEditForm from "../components/auth/teams/CreateEditForm";
import WaitingCompetitorsList from "../components/auth/teams/WaitingCompetitorsList";
import AddSettlement from "../components/authenticate/admin/AddSettlement";
import AddSport from "../components/authenticate/admin/AddSport";

Vue.component('roles-checkboxes', RolesCheckboxes);
Vue.component('roles-permissions', RolePermissions);
Vue.component('create-edit-form', CreateEditForm);
Vue.component('waiting-competitors-list', WaitingCompetitorsList);
Vue.component('add-settlement', AddSettlement);
Vue.component('add-sport', AddSport);

