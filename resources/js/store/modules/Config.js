
const state = () => ({
   appUrl: window.appConfig.appUrl,
    // oauthPasswordClient: {
    //     id: window.appConfig.oauthPasswordClient.id,
    //     secret: window.appConfig.oauthPasswordClient.secret,
    // }
});
const getters = {
    appUrl: function (state) {
        return state.appUrl;
    },
    appBasePath: function (state) {
        let appUrlObject = new URL(state.appUrl);
        return appUrlObject.pathname;
    }
};
const actions = {};
const mutations = {};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
