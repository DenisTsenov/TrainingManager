import {required, minLength} from 'vuelidate/lib/validators';
import WaitingCompetitorsList from '../components/auth/teams/WaitingCompetitorsList';

export default {
    components: {
        WaitingCompetitorsList
    },
    data() {
        return {
            name: this.team !== null ? this.team.name : '',
            trainer: '',
            trainers: {},
            errors: {},
            sendAllowed: true,
            hasBeenSend: false,
            serverErr: false,
            selectedTrainer: this.team !== null ? this.team.trainer : this.trainer,
        }
    },
    props: {
        team: {
            required: false,
            type: Object,
            default: false,
        },
        actionType: {
            required: true,
            type: String,
        },
    },
    validations: {
        name: {required, minLength: minLength(2)},
        trainer: {required}
    },
    methods: {
        loadTrainers() {
            axios.get('/admin/team/trainers')
                 .then(response => {
                     this.trainers = response.data;
                 }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else {
                    this.serverErr = true;
                }
            });
        },
        getCompetitors(e, trainer) {

        },
        send() {
            this.hasBeenSend = true;
            this.$v.$touch();

            if (this.$v.$invalid) return;

            if (this.sendAllowed) {
                this.sendAllowed = false;
                this.errors      = {};
                axios.post('/admin/team/store', {
                    'name': this.name,
                    'trainer_id': this.trainer.id,
                    'sport_id': this.trainer.sport_id,
                    'settlement_id': this.trainer.settlement_id
                })
                     .then(response => {
                         window.location = response.data.route;
                     }).catch(error => {
                    if (error.response.status === 422) {
                        this.sendAllowed = true;
                        this.errors      = error.response.data.errors || {};
                    } else {
                        this.serverErr = true;
                    }
                });
            }
        },
    },
    created: function () {
        this.loadTrainers();
    },
}
