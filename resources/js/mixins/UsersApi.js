import {th} from "vuetify/locale";
import {axiosInstance, POST} from "../plugins/instance.api.js";


let usersApi = {
    methods: {
        loginEnter: function (payloadRequestUser){
            return axiosInstance('/api/oauth',POST,undefined,payloadRequestUser,['company'])
        },
    }
};

export default usersApi;
