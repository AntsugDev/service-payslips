import {th} from "vuetify/locale";

let usersApi = {
    methods: {
        loginEnter: function (payloadRequestUser){
        return this.axios.post('/api/token-user',{
            data:payloadRequestUser
        });
        },
        /** USERS */
        getUsers: function (params, userId) {
            let usersIncludes = ['role'];
            let param = (userId !== undefined) ? '/' + userId : '';
            Object.assign(params, { includes: usersIncludes.join(',') });
            return this.axios.get(this.$store.getters['config/appUrl'] + '/api/v2/users' + param, {
                params: params,
                headers: {
                    Authorization: 'Bearer ' + this.user.jwtToken,
                    Accept: 'application/json'
                }
            })
        },
        postUser: function (params) {
            return this.axios.post(this.$store.getters['config/appUrl'] + '/api/v2/users', {
                data: params
            }, {
                headers: {
                    Authorization: 'Bearer ' + this.user.jwtToken,
                    Accept: 'application/json'
                }
            })
        },
        deleteUser: function (userId) {
            return this.axios.delete(this.$store.getters['config/appUrl'] + '/api/v2/users/' + userId, {
                headers: {
                    Authorization: 'Bearer ' + this.user.jwtToken,
                    Accept: 'application/json'
                }
            })
        },
        patchSelectedUser: function (userId, params) {
            return this.axios.patch(this.$store.getters['config/appUrl'] + '/api/v2/users/' + userId, {
                data: params,
            }, {
                headers: {
                    Authorization: 'Bearer ' + this.user.jwtToken,
                    Accept: 'application/json'
                }
            })
        },
        getUserRoles: function () {
            return this.axios.get(this.$store.getters['config/appUrl'] + '/api/v2/roles', {
                headers: {
                    Authorization: 'Bearer ' + this.user.jwtToken,
                    Accept: 'application/json'
                }
            })
        }
    }
};

export default usersApi;
