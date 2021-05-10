import {required, minLength} from 'vuelidate/lib/validators';

export default {
    data() {
        return {
            settlement: '',
            hasBeenSend: false,
            errors: {},
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
            axios.post(this.route, {name: this.settlement})
                 .then(response => {
                     this.hasBeenSend = true;
                 })
                 .catch(error => {
                     if (error.response.status === 422) {
                         console.log(error.response.data.errors.name[0])
                         this.errors = error.response.data.errors;
                     } else {
                         this.serverErr = true;
                     }
                 });
        }
    },
}