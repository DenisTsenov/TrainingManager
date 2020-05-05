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
        }
    },
    props: {
        user: {
            first_name: {
                type: String,
                required: true,
            },
            last_name: {
                type: String,
                required: true,
            },
            email: {
                type: String,
                required: true,
            },
            password: {
                type: String,
                required: true,
                validator: function (value) {
                    // The value must match the conf pass
                    return value === this.confirm_password;
                }
            },
            confirm_password: {
                type: String,
                required: true,
            }
        }
    },
    methods: {
        submit() {
            if (this.loaded) {
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
