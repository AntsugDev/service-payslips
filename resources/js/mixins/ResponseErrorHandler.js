let responseErrorHandler = {
    methods: {
        handleResponseError: function (error) {
            let response = error.response;
            if (response === undefined) {
                this.$store.commit('snackbar/update', {
                    show: true,
                    text: error.toString(),
                    color: 'error'
                });
            } else {
                let status = response.status;
                if (status === 401) {
                    this.$store.commit('snackbar/update', {
                        show: true,
                        text: 'Sessione scaduta',
                        color: 'error'
                    });
                    let self = this;
                    setTimeout(function () {
                        localStorage.removeItem('pds-provisioning-token');
                        self.$router.push({name: 'ApplicationLogin'})
                    }, 1000);
                } else {
                    let errors = response.data.errors;
                    if (errors === undefined) {
                        this.$store.commit('snackbar/update', {
                            show: true,
                            text: response.data.message,
                            color: 'error'
                        });
                    } else {
                        this.$store.commit('snackbar/update', {
                            show: true,
                            text: errors[0].detail,
                            color: 'error'
                        });
                    }
                }
            }
        }
    }
};
export default responseErrorHandler;
