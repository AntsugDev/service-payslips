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
            "cf" : state.data.user.cf,
            "email" : state.data.user.email,
            "role" : state.data.user.role,
            "company" : state.data.user.company !== undefined ? state.data.user.company.name : "",
            "created_at" : state.data.user.created_at,
            "updated_at" : state.data.user.updated_at,
        }
    },
    getEmailUser:function (state){
      return   state.data.user.email;
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
