let storeComputed = {
    computed: {
        config() {
            return this.$store.state.config;
        },
        user() {
            return this.$store.state.user;
        },
        snackbar() {
            return this.$store.state.snackbar;
        },
    },
};

export default storeComputed;
