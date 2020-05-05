import {required, minLength, email, sameAs,} from 'vuelidate/lib/validators';

export default {
    data() {
        return {
            userData: {
                'first_name': this.user.first_name,
                'last_name': this.user.last_name,
                'email': this.user.email,
                'password': this.password,
                'password_confirmation': this.password_confirmation,
            },
            errors: {},
            success: false,
            loaded: true,
            action: '',
            password: '',
            password_confirmation: '',
            submitted: false,
        }
    },
    validations: {
        userData: {
            first_name: {required,},
            last_name: {required,},
            email: {required, email,},
            password: {required, minLength: minLength(8)},
            password_confirmation: {required, sameAsPassword: sameAs('password')},
        }
    },
    props: {
        user: Object,
    },
    methods: {
        submit() {
            this.submitted = true;

            this.$v.$touch();

            if (this.$v.$invalid) {
                return;
            }

            if (this.loaded) {
                this.submitted = false;
                this.loaded  = false;
                this.success = false;
                this.errors  = {};
                axios.post(this.action, this.userData)
                     .then(response => {
                         this.userData.password              = '';
                         this.userData.password_confirmation = '';
                         this.loaded                         = true;
                         this.success                        = true;
                     }).catch(error => {
                    if (error.response.status === 422) {
                        this.loaded = true;
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },
    },
}
