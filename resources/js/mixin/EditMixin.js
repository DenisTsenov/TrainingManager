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
            password: '',
            password_confirmation: '',
            errors: {},
            success: false,
            sendAllowed: true,
            hasBeenSend: false,
            serverErr: false,
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
        required: true,
        user: Object,
    },
    methods: {
        submit() {
            this.hasBeenSend = true;

            this.$v.$touch();

            if (this.$v.$invalid) return this.success = false;

            if (this.sendAllowed) {
                this.sendAllowed = false;
                this.errors      = {};
                axios.put('/profile/' + this.user.id + '/update', this.userData)
                     .then(response => {
                         this.userData.password              = '';
                         this.userData.password_confirmation = '';
                         this.sendAllowed                    = true;
                         this.success                        = true;
                         this.hasBeenSend                    = false; // if back end validation do not pass we shall be able to send the form again with front end validation
                     }).catch(error => {
                    if (error.response.status === 422) {
                        this.sendAllowed = true;
                        this.success     = false;
                        this.hasBeenSend = false; // if back end validation do not pass we shall be able to send the form again with front end validation
                        this.errors      = error.response.data.errors || {};
                    } else {
                        this.serverErr = true;
                    }
                });
            }
        },
    },
}
