import { createRouter, createWebHistory } from 'vue-router';
import store from '../store'


import Home from "../views/Home.vue";
/** Login */
import ApplicationLogin from "../views/Logins/ApplicationLogin.vue";

/** Admin */

import moment from "moment";
import UsersIndex from "../views/Admin/Users/UsersIndex.vue";
import EditPassword from "../views/Admin/Users/EditPassword.vue";
import ResetPassword from "../views/Admin/Users/ResetPassword.vue";
import CreateUser from "../views/Admin/Users/CreateUser.vue";
import ListUser from "../views/Admin/ListUser.vue";
import ChangeCompany from "../views/Admin/Company/ChangeCompany.vue";
import DeleteUser from "../views/Admin/Users/DeleteUser.vue";
import List from "../views/Admin/Company/List.vue";
import LoggerList from "../views/Admin/LoggerList.vue";
import ListPassSaveCategory from "../views/PassSave/Category/ListPassSaveCategory.vue";
import CreatePassSaveCategory from "../views/PassSave/Category/CreatePassSaveCategory.vue";
import Tester from "../views/Tester/Tester.vue";
import DeleteCategory from "../views/PassSave/Category/DeleteCategory.vue";
import ListPassSaveGroups from "../views/PassSave/Groups/ListPassSaveGroups.vue";
import CreatePassSaveGroups from "../views/PassSave/Groups/CreatePassSaveGroups.vue";
import DeleteGroups from "../views/PassSave/Groups/DeleteGroups.vue";

const router = createRouter({
    history: createWebHistory(store.getters['config/appBasePath']),
    routes: [
        {
            path: '',
            name: 'Home',
            component: Home,
            beforeEnter: (to, from, next) => {
                let jwt = store.getters['user/getJwt'];
                if (jwt.access_token !== null) {
                    let expired = jwt.expired
                    let now   = moment();
                    let fisrt_access= store.getters['user/getFirstAccess']
                    if(expired > now.format('DD/MM/YYYY HH:mm:ss')){
                        if(!fisrt_access)
                            next();
                        else
                            next({ name: 'ResetPassword',query:{
                                        email: btoa(store.getters['user/getEmailUser']),
                                        uuid: btoa(store.getters['user/getId'])
                                    } })
                    }
                    else{
                        next({ name: 'ApplicationLogin',query:{logout: "Session exipred"} });
                    }
                } else {
                    next({ name: 'ApplicationLogin',query:{logout:"Errore in fase di login, autorizzazione negata"} });
                }
            },
            children: [
                {
                    path: 'user',
                    children: [
                        {
                            path:'details',
                            name:'UserIndex',
                            component: UsersIndex
                        },
                        {
                            path:'password/:id',
                            name:'EditPassword',
                            component: EditPassword
                        },
                        {
                            path:'admin',
                            name:'ListUser',
                            component: ListUser
                        },
                        {
                            path:'delete/:id',
                            name:'DeleteUser',
                            component: DeleteUser
                        },

                    ]
                },
                {
                    path:'company',
                    children:[
                        {
                            path:'change/:id',
                            component:ChangeCompany,
                            name: 'ChangeCompany'
                        },
                        {
                            path:'list',
                            component:List,
                            name: 'ListCompany'
                        },
                        {
                            path:'logger',
                            component:LoggerList,
                            name: 'LoggerList'
                        }
                    ]
                },
                {
                    path:'pass',
                    children:[

                        {
                            path:'category',
                            children:[

                                {
                                    path: 'list',
                                    component:ListPassSaveCategory,
                                    name:'ListPassSaveCategory'
                                },

                                {
                                    path: 'create',
                                    component:CreatePassSaveCategory,
                                    name:'CreatePassSaveCategory'
                                },
                                {
                                    path: 'delete/:id',
                                    component:DeleteCategory,
                                    name:'DeleteCategory'
                                }
                            ]
                        },
                        {
                            path:'groups',
                            children:[

                                {
                                    path: 'list',
                                    component:ListPassSaveGroups,
                                    name:'ListPassSaveGroups'
                                },

                                {
                                    path: 'create',
                                    component:CreatePassSaveGroups,
                                    name:'CreatePassSaveGroups'
                                },
                                {
                                    path: 'delete/:id',
                                    component:DeleteGroups,
                                    name:'DeleteGroups'
                                }
                            ]
                        }

                    ]
                },
            ]
        },
        {
            path: '/application-login',
            name: 'ApplicationLogin',
            component: ApplicationLogin,

        },
        {
            path:'/reset/password',
            name:'ResetPassword',
            component: ResetPassword
        },
        {
            path:'/user/create',
            name:'CreateUser',
            component: CreateUser
        },
        {
            path: '/:pathMatch(.*)*',
            redirect: { name: 'ApplicationLogin', query: {logout:"Page not found"} }
        }
    ],
});

export default router
