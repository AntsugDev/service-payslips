import store from "../store/index.js";

export const Menu = () =>   {
    let getAdmin = store.getters['user/getAdmin'];
    if(getAdmin)
        return [
            {
                text:'List user',
                icon: 'mdi-account-group',
                routeName: 'ListUser',
                children: [],
            },
            {
                text:'List Company',
                icon: 'mdi-domain',
                routeName: null,
                children: [],
            },

        ]
    else
        return []
}
