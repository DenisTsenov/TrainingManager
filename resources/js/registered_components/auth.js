import RegisterForm from './../components/RegisterForm';
import LoginForm from "./../components/LoginForm";
import EditForm from "../components/auth/EditForm";
import TeamsList from "../components/auth/teams/TeamsList";
import EditButton from "../components/auth/buttons/EditButton";

Vue.component('register-form', RegisterForm);
Vue.component('login-form', LoginForm);
Vue.component('edit-from', EditForm);
Vue.component('team-list', TeamsList);
Vue.component('edit-button', EditButton);
