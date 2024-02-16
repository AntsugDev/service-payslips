let whoAmIApi = {
    methods: {
        getWhoAmI: function () {
            return this.axios.get(
                this.$store.getters['config/appUrl'] + '/api/v2/who_am_i',
                {
                    headers: {
                        Authorization: 'Bearer ' + this.user.jwtToken,
                        Accept: 'application/json'
                    }
                })
        },
    }
};

export default whoAmIApi;
