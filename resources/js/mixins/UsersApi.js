import {axiosInstance, GET, POST, PUT} from "../plugins/instance.api.js";


let usersApi = {
    methods: {
        loginEnter: function (payloadRequestUser){
            return axiosInstance('/api/oauth',POST,payloadRequestUser,['company'])
        },
        changePassword: function (payloadRequestUser, id){
            let path = '/api/v1/user/password/'+id
            return axiosInstance(path,POST,payloadRequestUser);
        },
        stepperAjax: function (payloadRequest){
            let path = '/api/reset/check_email/'+payloadRequest
            return axiosInstance(path,GET)
        },
        changePasswordStepper: function (payloadRequest,uuid){
            let path = '/api/reset/update_password/'+uuid
            return axiosInstance(path,POST,payloadRequest)
        },
        createUser: function (payloadRequest){
            return axiosInstance('/api/create',PUT,payloadRequest)
        }

    }
};

export default usersApi;
