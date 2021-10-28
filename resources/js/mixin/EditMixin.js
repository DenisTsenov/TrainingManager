import {email, minLength, required, sameAs,} from 'vuelidate/lib/validators';

export default {
    data() {
        return {
            userData: {
                'first_name': this.user.first_name,
                'last_name': this.user.last_name,
                'email': this.user.email,
                'settlement_id': this.user.settlement_id,
                'sport_id': this.user.sport_id,
                'password': this.password,
                'password_confirmation': this.password_confirmation,
            },
            password: '',
            password_confirmation: '',
            errors: {},
            settlements: {},
            settlement: '',
            sports: {},
            sport: '',
            success: false,
            sendAllowed: true,
            hasBeenSend: false,
            serverErr: false,
            canChangeSettlementSport: '',
            selectSport: false,
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
    props: {
        required: true,
        user: Object | Array,
        destroyRoute: {
            required: false,
            type: String | null,
        },
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
                         this.userData.settlement            = '';
                         this.userData.sport                 = '';
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
        loadSettlements(settlement = false) {
            axios.get('/settlements',)
                 .then(response => {
                     this.settlements = response.data;

                     if (settlement) return this.loadSports(settlement);

                     this.loadSports(this.userData.settlement_id);
                 }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else {
                    this.serverErr = true;
                }
            });
        },
        loadSports(settlement) {
            axios.get('/settlement/sports', {
                params: {
                    settlement_id: settlement
                }
            }).then(response => {
                this.sports = response.data;
                if (!(this.userData.sport_id in this.sports)) this.userData.sport_id = '';
            }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else {
                    this.serverErr = true;
                }
            });
        },
        setSettlement(settlement) {
            this.userData.settlement_id = settlement;
            this.loadSettlements(settlement);
        },
        setSport(e, sport) {
            this.userData.sport_id = sport;
        },
    },
    created() {
        this.loadSettlements();
        this.settlement = this.userData.settlement_id;
        this.sport      = this.userData.sport_id;
        this.isInTeam   = this.user.team_id != null;
    }
}
