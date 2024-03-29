import {required, minLength, email, sameAs,} from 'vuelidate/lib/validators';

export default {
    data() {
        return {
            userData: {
                'first_name': this.first_name,
                'last_name': this.last_name,
                'settlement_id': this.settlement_id,
                'sport_id': this.sport_id,
                'email': this.email,
                'password': this.password,
                'password_confirmation': this.password_confirmation,
            },
            first_name: '',
            last_name: '',
            email: '',
            password: '',
            password_confirmation: '',
            settlements: {},
            settlement: '',
            sports: {},
            sport: '',
            settlementSelected: false,
            success: false,
            sendAllowed: true,
            hasBeenSend: false,
            errors: {},
            serverErr: false,
        }
    },
    validations: {
        userData: {
            first_name: {required,},
            last_name: {required,},
            settlement_id: {required,},
            sport_id: {required,},
            email: {required, email,},
            password: {required, minLength: minLength(8)},
            password_confirmation: {required, sameAsPassword: sameAs('password')},
        }
    },
    methods: {
        submit() {
            this.hasBeenSend = true;

            this.$v.$touch();

            if (this.$v.$invalid) return this.success = false;

            if (this.sendAllowed) {
                this.sendAllowed = false;
                this.errors      = {};
                axios.post('/store', this.userData)
                     .then(response => {
                         this.userData           = {};
                         this.settlement         = {};
                         this.sport              = {};
                         this.settlementSelected = false;
                         this.sendAllowed        = true;
                         this.success            = true;
                         this.hasBeenSend        = false; // if back end validation do not pass we shall be able to send the form again with front end validation
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
        getSettlements() {
            axios.get('/settlements')
                 .then(response => {
                     this.settlements = response.data;
                 }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else {
                    this.serverErr = true;
                }
            });
        },
        getSports(e, settlementId) {
            axios.get('/settlement/sports', {
                params: {
                    settlement_id: settlementId
                }
            }).then(response => {
                this.settlementSelected     = true;
                this.userData.settlement_id = settlementId
                this.sports                 = response.data;
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else {
                    this.serverErr = true;
                }
            });
        },
        setSport(e, sport) {
            this.userData.sport_id = sport;
        }
    },
    created: function () {
        this.getSettlements();
    }
}
