import {axiosInstance, GET,PUT} from "../plugins/instance.api.js";

const Companies = {
    methods: {
        listAll: function (){
            return axiosInstance('/api/companies/all',GET);
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


    }
}

export default Companies;
