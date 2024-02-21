import {axiosInstance, GET} from "../plugins/instance.api.js";

const Companies = {
    methods: {
        listAll: function (){
            return axiosInstance('/api/companies/all',GET);
        },
        childrenUser:function (){
            return axiosInstance('/api/v1/companies',GET)
        }

    }
}

export default Companies;
