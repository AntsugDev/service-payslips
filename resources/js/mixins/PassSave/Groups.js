import {axiosInstance, DELETE, GET, POST} from "../../plugins/instance.api.js";

const Groups = {
    methods:{
        lista: function (){
            return axiosInstance('/api/v1/pass/pass_groups ',GET);
        },
        create:function (payload){
            return axiosInstance('/api/v1/pass/pass_groups',POST,payload)
        },
        destroy:function (uuid){
            let path = '/api/v1/pass/pass_groups/'+uuid
            return axiosInstance(path,DELETE)
        }
    }
}

export default Groups;
