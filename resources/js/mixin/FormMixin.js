export default {
    data() {
        return {
            fields: {},
            errors: {},
            success: false,
            loaded: true,
            action: '',
            login: false
        }
    },
    methods: {
        submit() {
            if (this.loaded) {
                this.loaded  = false;
                this.success = false;
                this.errors  = {};
                axios.post(this.action, this.fields)
                     .then(response => {
                         this.fields  = {};
                         this.loaded  = true;
                         this.success = true;
                         if (this.login) {
                             window.location = response.data.route;
                         }
                     }).catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },
    },
}
