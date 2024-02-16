const state = () => ({
    show: false,
    text: null,
    color: null
});

const getters = {};
const actions = {};
const mutations = {
    update(state, attributes) {
        for (let prop in attributes) {
            if (Object.prototype.hasOwnProperty.call(attributes, prop)) {
                state[prop] = attributes[prop]
            }
        }
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
