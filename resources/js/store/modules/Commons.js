const state = () => ({
    cuaaFound: [],
    fileName: ''
});
const getters = {
    cuaaFound: function (state) {
        return state.cuaaFound;
    },
    fileName: function (state) {
        return state.fileName;
    }
};
const actions = {};
const mutations = {
    setCuaa: function (state, cuaa) {
        state.cuaaFound = cuaa;
    },
    setFileName: function (state, fileName) {
        state.fileName = fileName;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
