import {axiosInstance, GET, PATCH, PUT} from "../plugins/instance.api.js";

const Companies = {
    methods: {
        listAll: function (){
            return axiosInstance('/api/companies/all',GET,null,['city']);
        },
        childrenUser:function (){
            return axiosInstance('/api/v1/companies',GET)
        },
        listCities:function (){
            return axiosInstance('/api/cities',GET)
        },
        createCompany: function (payloadRequest){
            return axiosInstance('/api/companies/create',PUT,payloadRequest)
        },
        updateUserCompany: function (user_id,company_id){
            let path = '/api/v1/user/admin/change/'+user_id+'/'+company_id
            return axiosInstance(path,PATCH);
        }


    }
}

export default Companies;
