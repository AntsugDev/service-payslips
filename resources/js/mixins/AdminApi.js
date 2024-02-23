import {axiosInstance, GET} from "../plugins/instance.api.js";

const AdminApi = {
    methods: {
        listAllAdmin: function (){
            return axiosInstance('/api/v1/user/admin',GET,null,['company']);
        },
        detailsUser: function ($uuid){
            let path = '/api/v1/user/admin/'+$uuid;
            return axiosInstance(path,GET,null,['company'])
        }
    }
}

export default AdminApi;
