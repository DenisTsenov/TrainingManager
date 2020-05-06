import {required, minLength, email,} from 'vuelidate/lib/validators';

export default {
    data() {
        return {
            userData: {
                'email': this.email,
                'password': this.password,
            },
            email: '',
            password: '',
            action: '',
            errors: {},
            submitted: false,
            serverErr: false,
        }
    },
    validations: {
        userData: {
            email: {required, email,},
            password: {required, minLength: minLength(8),},
        }
    },
    methods: {
        submit() {
            this.submitted = true;
            this.$v.$touch();

            if (this.$v.$invalid) return;

            if (this.submitted) {
                this.errors = {};
                axios.post(this.action, this.userData)
                     .then(response => {
                         window.location = response.data.route;
                     }).catch(error => {
                    if (error.response.status === 422) {
                        this.submitted = false;
                        this.errors    = error.response.data.errors || {};
                    } else {
                        this.serverErr = true;
                    }
                });
            }
        },
    },
}
