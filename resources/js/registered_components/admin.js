import RolesCheckboxes from "../components/auth/admin/RolesCheckboxes";
import RolePermissions from "../components/auth/admin/RolePermissions";
import CreateEditForm from "../components/auth/teams/CreateEditForm";
import WaitingCompetitorsList from "../components/auth/teams/WaitingCompetitorsList";
import CreateEditSettlement from "../components/auth/settlement/CreateEditSettlement";
import CreateEditSport from "../components/auth/sport/CreateEditSport";
import SettlementsList from "../components/auth/settlement/SettlemenstList";
import SportList from "../components/auth/sport/SportList";

Vue.component('roles-checkboxes', RolesCheckboxes);
Vue.component('roles-permissions', RolePermissions);
Vue.component('create-edit-form', CreateEditForm);
Vue.component('waiting-competitors-list', WaitingCompetitorsList);
Vue.component('create-edit-settlement', CreateEditSettlement);
Vue.component('create-edit-sport', CreateEditSport);
Vue.component('settlements-list', SettlementsList);
Vue.component('sport-list', SportList);
