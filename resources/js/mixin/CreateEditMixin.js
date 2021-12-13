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
        edit: {
            required: false,
            type: Boolean | String
        },
        distribution: {
            required: false,
            type: Boolean,
            default: true,
        },
        teamId: {
            required: false,
            type: Number | String,
            default: 0,
        },
        destroyRoute: {
            required: false,
            type: String,
        },
    },
    validations: {
        name: {required, minLength: minLength(2)},
        trainer: {required}
    },
    methods: {
        getUsers(e, trainerId) {
            if (this.edit) return;

            axios.get('/admin/team/users/' + trainerId,)
                 .then(response => {
                     this.members = [];

                     this.distribution = response.data.length == 0 ? false : true;

                     this.users = response.data;
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
                    'members': this.members,
                    'team_id': this.team !== undefined && this.team != null ? this.team.id : this.teamId
                })
                //      .then(response => {
                //          window.location = response.data.route;
                //      }).catch(error => {
                //     if (error.response.status === 422) {
                //         this.sendAllowed = true;
                //         this.errors      = error.response.data.errors || {};
                //     } else {
                //         this.serverErr = true;
                //     }
                // });
            }
        },
        loadTrainers() {
            let params = false;

            if (this.edit && this.team.members.length > 0) params = {trainer_id: this.team.trainer.id}

            axios.get('/admin/team/trainers', {params})
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
            this.name    = this.team.name;
            this.trainer = this.team.trainer.id;
            this.users   = this.team.members;

            this.users.forEach((user) => {
                if (user.team_id == this.team.id) {
                    this.members.push(user.id);
                }
            })
        }
    },
}
