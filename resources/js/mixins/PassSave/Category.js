import {axiosInstance, DELETE, GET, POST} from "../../plugins/instance.api.js";

const Category = {
    methods:{
        lista: function (){
            return axiosInstance('/api/v1/pass/pass_category ',GET);
        },
        create:function (payload){
            return axiosInstance('/api/v1/pass/pass_category',POST,payload)
        },
        destroy:function (uuid){
            let path = '/api/v1/pass/pass_category/'+uuid
            return axiosInstance(path,DELETE)
        }
    }
}

export default Category;
