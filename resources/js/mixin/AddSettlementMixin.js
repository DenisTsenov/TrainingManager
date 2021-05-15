import {required, minLength} from 'vuelidate/lib/validators';

export default {
    data() {
        return {
            settlement: '',
            hasBeenSend: false,
            errors: {},
            success: false,
            sendAllowed: true,
            serverErr: false,
        }
    },
    validations: {
        settlement: {
            required,
            minLength: minLength(2)
        }
    },
    props: {
        route: {
            required: true,
            type: String,
        }
    },
    methods: {
        create() {
            this.hasBeenSend = true;
            this.$v.$touch();

            if (this.$v.$invalid) return;

            if (this.sendAllowed) {
                this.sendAllowed = false;
                this.errors      = {};
                axios.post(this.route, {name: this.settlement})
                     .then(response => {
                         this.sendAllowed = true;
                         this.success = true;
                     })
                     .catch(error => {
                         if (error.response.status === 422) {
                             this.sendAllowed = true;
                             this.errors      = error.response.data.errors || {};
                         } else {
                             this.serverErr = true;
                         }
                         this.hasBeenSend = false;
                     });
            }
        }
    },
}