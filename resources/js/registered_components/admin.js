import RolesCheckboxes from "../components/auth/admin/RolesCheckboxes";
import RolePermissions from "../components/auth/admin/RolePermissions";
import CreateEditForm from "../components/auth/teams/CreateEditForm";
import WaitingCompetitorsList from "../components/auth/teams/WaitingCompetitorsList";
import CreateEditSettlement from "../components/auth/settlement/CreateEditSettlement";
import AddSport from "../components/auth/sport/AddSport";
import SettlementsList from "../components/auth/settlement/SettlemenstList";

Vue.component('roles-checkboxes', RolesCheckboxes);
Vue.component('roles-permissions', RolePermissions);
Vue.component('create-edit-form', CreateEditForm);
Vue.component('waiting-competitors-list', WaitingCompetitorsList);
Vue.component('create-edit-settlement', CreateEditSettlement);
Vue.component('add-sport', AddSport);
Vue.component('settlements-list', SettlementsList);
