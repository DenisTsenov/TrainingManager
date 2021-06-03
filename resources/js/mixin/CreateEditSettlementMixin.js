import {maxLength, minLength, required} from 'vuelidate/lib/validators';

export default {
    data() {
        return {
            settlement: '',
            sports: [],
            hasBeenSend: false,
            errors: {},
            sendAllowed: true,
            serverErr: false,
        }
    },
    validations: {
        settlement: {
            required,
            minLength: minLength(2),
            maxLength: maxLength(50),
        }
    },
    props: {
        route: {
            required: true,
            type: String,
        },
        actionType: {
            required: true,
            type: String,
        },
        settlementEdit: {
            required: false,
            type: Object,
            default: false,
        },
    },
    methods: {
        create() {
            this.hasBeenSend = true;
            this.$v.$touch();

            if (this.$v.$invalid) return;
            this.sports = this.sports.filter(sport => {
                return sport.checked;
            })

            let sportsToSend = [];
            this.sports.forEach((sport) => {
                if (!sportsToSend.includes(sport)) {
                    sportsToSend.push(sport.id);
                }
            });

            if (this.sendAllowed) {
                this.sendAllowed = false;
                this.errors      = {};
                axios.post(this.route, {name: this.settlement, sports: sportsToSend})
                     .then(response => {
                         window.location = response.data.route;
                     })
                     .catch(error => {
                         if (error.response.status === 422) {
                             this.sendAllowed = true;
                             this.errors      = error.response.data.errors || {};
                         } else {
                             this.serverErr = true;
                         }
                     });
                this.hasBeenSend = false;
            }
        },
        getSports() {
            let settlement = null;

            if (this.settlementEdit != null) settlement = this.settlementEdit.id
            axios.get('/admin/sports/get', {
                params: {
                    settlement_id: settlement
                }
            })
                 .then(response => {
                     this.sports = response.data;
                 }).catch(error => {
                this.serverErr = true;
            });
        },
        check(id) {
            this.sports[id - 1]['checked'] = true;
        }
    },
    created() {
        this.getSports();
        this.settlement = '';

        if (this.settlementEdit != null) {
            this.settlement   = this.settlementEdit.name;
        }
    },
}
