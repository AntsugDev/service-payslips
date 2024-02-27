<template>
    <v-app id="inspire">
        <SnackBarCommon></SnackBarCommon>
        <v-navigation-drawer
            app
            v-model="config.drawer"
            color="primary"
            :clipped="true"
            :mini-variant.sync="mini"
            permanent
            flat
        >
            <v-divider></v-divider>

            <v-list dense>
                <template v-for="(item, index) in items" :key="index">
                    <v-list-item  link v-if="item.children">
                        <v-list-item-content >
                            <v-list-item-title>{{ item.text }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-group v-else>
                        <template v-slot:activator>
                            <v-list-item-content>
                                <v-list-item-title>{{ item.text }}</v-list-item-title>
                            </v-list-item-content>
                        </template>

                        <v-list-item v-for="(child, childIndex) in item.children" :key="childIndex" link>
                            <v-list-item-content>
                                <v-list-item-title>{{ child.text }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-group>

                </template>
            </v-list>





        </v-navigation-drawer>


        <v-app-bar app color="primary" :clipped-left="true" class="elevation-1">
            <v-app-bar-nav-icon @click.stop="$store.commit('config/changeDrawer')" class="primary white--text"></v-app-bar-nav-icon>
            <v-toolbar-title>Service PaySlips</v-toolbar-title>
            <v-spacer></v-spacer>
            <BtnLogout></BtnLogout>
        </v-app-bar>
        <v-main>

            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>


import storeComputed from "../mixins/storeComputed.js";
import SnackBarCommon from "./Common/SnackBarCommon.vue";
import BtnLogout from "./Common/BtnLogout.vue";
import {Menu} from "../plugins/menu.list.js";
import Config from "../store/modules/Config.js";

export default {
    components: {BtnLogout, SnackBarCommon},
    mixins: [storeComputed],
    name: "Home",
    data: () => ({
        mini: false,
        userMenu: false,
        drawerItems: Menu(),
        items: [
            { text: 'Dashboard' },
            {
                text: 'Menu with Submenu',
                children: [
                    { text: 'Submenu Item 1' },
                    { text: 'Submenu Item 2' }
                ]
            },
        ]
    }),
    methods: {
        logout: function () {
            this.$router.push({ name: 'ApplicationLogin',query:{logout: 'Logout effettuato'} }).then(() => {
            }).catch(e => console.log(e));
        },
    },
}
</script>

<style scoped></style>
