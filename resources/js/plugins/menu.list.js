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
                routeName: 'ListCompany',
                children: [],
            },
            {
                text:'Logger',
                icon: 'mdi-file-refresh',
                routeName: 'LoggerList',
                children: [],
            },

        ]
    else
        return [
            {
                text:'Pass Save',
                icon: 'mdi-content-save',
                routeName: null,
                children: [
                    {
                        text:'Category',
                        icon: 'mdi-application-cog',
                        routeName: 'ListPassSaveCategory',
                        children: [],
                    },
                    {
                        text:'Groups',
                        icon: 'mdi-group',
                        routeName: 'ListPassSaveGroups',
                        children: [],
                    }
                ],
            }

        ]
}
