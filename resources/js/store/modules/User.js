const state = () => ({
    user: {
        isAuthenticated: false,
        firstName: null,
        lastName: null,
        email: null,
        role: null,
        jwtToken: null,
        expired: null,
    }
});

const getters = {};
const actions = {
    setUsers(state,payload){
        state.user = payload
    }


};
const mutations = {
    update(state, attributes) {
        for (let prop in attributes) {
            if (Object.prototype.hasOwnProperty.call(attributes, prop)) {
                state[prop] = attributes[prop]
            }
        }
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
