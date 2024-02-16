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
        },
        company:{
            id: null,
            name: null,
            city: null,
            address: null,
            email: null,
            phone:null
        }

    }
});

const getters = {};
const actions = {



};
const mutations = {
    update(state, attributes) {
        for (let prop in attributes) {
            if (Object.prototype.hasOwnProperty.call(attributes, prop)) {
                state[prop] = attributes[prop]
            }
        }
    },
    create(state,payload){
        state.data = payload
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
