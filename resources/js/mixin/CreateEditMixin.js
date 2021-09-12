import {minLength, required} from 'vuelidate/lib/validators';

export default {
    data() {
        return {
            name: '',
            trainer: '',
            trainers: {},
            errors: {},
            users: {},
            members: [],
            sendAllowed: true,
            hasBeenSend: false,
            serverErr: false,
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
        route: {
            required: true,
            type: String,
        },
    },
    validations: {
        name: {required, minLength: minLength(2)},
        trainer: {required}
    },
    methods: {
        getUsers(e, trainerId) {
            axios.get('/admin/team/users/' + trainerId,)
                 .then(response => {
                     this.members = [];
                     this.users   = response.data;
                 }).catch(error => {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                } else {
                    this.serverErr = true;
                }
            });
        },
        send() {
            this.hasBeenSend = true;
            this.$v.$touch();

            if (this.$v.$invalid) return;

            if (this.sendAllowed) {
                this.sendAllowed = false;
                this.errors      = {};
                axios.post(this.route, {
                    'name': this.name,
                    'trainer_id': this.trainer,
                    'members': this.members
                }).then(response => {
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
    },
    created() {
        this.loadTrainers();
        if (this.team != null) {
            console.log(this.team.members.competitors)
            this.users   = this.team.members;
            this.name    = this.team.name;
            this.trainer = this.team.trainer.id;
        }
    },
}
