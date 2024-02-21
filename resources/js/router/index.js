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
                    let now = moment();
                   if(expired > now.format('DD/MM/YYYY HH:mm:ss'))
                    next();
                   else{
                       next({ name: 'ApplicationLogin',query:{logout: "Session exipred"} });
                   }
                } else {
                    next({ name: 'ApplicationLogin' });
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

                    ]
                }
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
            redirect: { name: 'Home', params: {} }
        }
    ],
});

export default router
