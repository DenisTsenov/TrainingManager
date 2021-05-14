import RegisterForm from './../components/RegisterForm';
import LoginForm from "./../components/LoginForm";
import EditForm from "../components/auth/EditForm";
import DistributeCompetitors from "../components/auth/DistributeCompetitors";
import TeamsList from "../components/auth/teams/TeamsList";
import EditTeamButton from "../components/auth/teams/EditTeamButton";

Vue.component('register-form', RegisterForm);
Vue.component('login-form', LoginForm);
Vue.component('edit-from', EditForm);
Vue.component('distribute-competitors', DistributeCompetitors);
Vue.component('team-list', TeamsList);
Vue.component('edit-team-button', EditTeamButton);
