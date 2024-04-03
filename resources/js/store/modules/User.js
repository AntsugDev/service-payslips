const state = () => ({
    data: {
        user:{
            id: null,
            name: null,
            cf:null,
            email:null,
            isAuthenticated: false,
            role: null,
            jwt:{
                type: null,
                expired: null,
                access_token: null
            },
            company:{
                id: null,
                name: null,
                city: null,
                address: null,
                email: null,
                phone:null
            }
        },


    }
});

const getters = {
    getJwt: function (state){
        return state.data.user.jwt
    },
    getIsAuth: function (state){
        return state.data.user.isAuthenticated
    },
    getDatiUser:function (state){
        return {
            "id" : state.data.user.id,
            "name": state.data.user.name,
            "code_user" : state.data.user.code_user,
            "email" : state.data.user.email,
            "role" : state.data.user.role,
            "company" : state.data.user.company !== null ? state.data.user.company.name : "",
            "password_at" : state.data.user.password_at !== null ? state.data.user.password_at : "",
            "created_at" : state.data.user.created_at !== null ? state.data.user.created_at : "",
            "updated_at" : state.data.user.updated_at !== null ? state.data.user.updated_at: "",
            "change_password" : state.data.user.change_password !== null ? state.data.user.change_password: false,
        }
    },
    getEmailUser:function (state){
      return   state.data.user.email;
    },
    getRole: function (state){
        return state.data.user.role === 'user'
    },
    getCompany: function (state){
        return state.data.user.company !== null ? state.data.user.company.id : null;
    },
    getId: function (state){
        return state.data.user.id;
    },
    getFirstAccess: function (state) {
        return state.data.user.change_password !== null ? state.data.user.change_password : false
    },
    getAdmin: function (state){
        return state.data.user.role === 'Admin'
    }
};
const actions = {};
const mutations = {
    create(state, attributes) {
        state.data = attributes.data;
    },

};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
