import RolesCheckboxes        from "../components/auth/admin/RolesCheckboxes";
import RolePermissions        from "../components/auth/admin/RolePermissions";
import CreateEditTeam         from "../components/auth/teams/CreateEditTeam";
import TeamMemberCard         from "../components/auth/teams/TeamMemberCard";
import TeamsList              from "../components/auth/teams/TeamsList";
import CreateEditSettlement   from "../components/auth/admin/settlement/CreateEditSettlement";
import CreateEditSport        from "../components/auth/admin/sport/CreateEditSport";
import SettlementsList        from "../components/auth/admin/settlement/SettlemenstList";
import SportList              from "../components/auth/admin/sport/SportList";
import ToggleActivationButton from "../components/auth/buttons/ToggleActivationButton";
import DistributeUsersList    from "../components/auth/distribution/DistributeUsersList";
import RemoveTeamButton       from "../components/auth/teams/RemoveTeamButton";
import TeamHistory            from "../components/auth/teams/TeamHistory";
import DistributeUser         from "../components/auth/distribution/DistributeUser";

Vue.component('roles-checkboxes', RolesCheckboxes);
Vue.component('roles-permissions', RolePermissions);
Vue.component('create-edit-team', CreateEditTeam);
Vue.component('team-member-card', TeamMemberCard);
Vue.component('team-list', TeamsList);
Vue.component('create-edit-settlement', CreateEditSettlement);
Vue.component('create-edit-sport', CreateEditSport);
Vue.component('settlements-list', SettlementsList);
Vue.component('sport-list', SportList);
Vue.component('toggle-activation-button', ToggleActivationButton);
Vue.component('distribute-users-list', DistributeUsersList);
Vue.component('remove-team-button', RemoveTeamButton);
Vue.component('team-history', TeamHistory);
Vue.component('distribute-user', DistributeUser);
