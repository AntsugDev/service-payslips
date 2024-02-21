import {axiosInstance, GET} from "../plugins/instance.api.js";

const Companies = {
    methods: {
        listAll: function (){
            return axiosInstance('/api/companies/all',GET);
        }
    }
}

export default Companies;
