import RegisterForm from './../components/RegisterForm';
import LoginForm from "./../components/LoginForm";
import EditForm from "../components/auth/EditForm";
import EditButton from "../components/auth/buttons/EditButton";
import MembershipHistory from "../components/auth/MembershipHistory";
import RedirectButton from "../components/auth/buttons/RedirectButton";
import DisableProfileButton from "../components/auth/buttons/DisableProfileButton";

Vue.component('register-form', RegisterForm);
Vue.component('login-form', LoginForm);
Vue.component('edit-from', EditForm);
Vue.component('edit-button', EditButton);
Vue.component('membership-history', MembershipHistory);
Vue.component('redirect-button', RedirectButton);
Vue.component('disable-profile-button', DisableProfileButton);
