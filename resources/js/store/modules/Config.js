
const state = () => ({
   appUrl: window.appConfig.appUrl,
    drawer:false
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
    },
    getDrawer:function (state){

    }
};
const actions = {};
const mutations = {
    changeDrawer:function (state){
        if(state.drawer)
            state.drawer = false;
        else
            state.drawer = true;

    }

};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
