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
            flat>
            <v-list dense dark>
                <template v-for="item in drawerItems">
                    <v-list-item v-if="item.children.length === 0" :key="item.text" :to="{ name: item.routeName }">
                        <v-list-item-content>
                            <v-icon size="small">{{item.icon}}</v-icon>&nbsp;<span style="vertical-align: bottom">{{ item.text }}</span>
                        </v-list-item-content>
                    </v-list-item>
                    <!--                    <v-list-group v-else :key="item.text" v-model="item.active" :prepend-icon="item.icon" color="white">-->
                    <!--                        <template v-slot:activator>-->
                    <!--                            <v-list-item-content>-->
                    <!--                                <v-list-item-title v-text="item.text" class="white&#45;&#45;text font-weight-bold text-wrap">-->
                    <!--                                </v-list-item-title>-->
                    <!--                            </v-list-item-content>-->
                    <!--                        </template>-->
                    <!--                        <v-list-item v-for="child in item.children" :key="child.text" ripple link-->
                    <!--                                     :to="{ name: child.routeName }">-->
                    <!--                            <v-list-item-content>-->
                    <!--                                <v-list-item-title v-text="child.text" class="white&#45;&#45;text text-wrap"></v-list-item-title>-->
                    <!--                            </v-list-item-content>-->
                    <!--                        </v-list-item>-->
                    <!--                    </v-list-group>-->
                </template>
            </v-list>
        </v-navigation-drawer>


        <v-app-bar app color="primary" :clipped-left="true" class="elevation-1">
            <v-app-bar-nav-icon @click.stop="$store.commit('config/changeDrawer')" class="primary white--text"></v-app-bar-nav-icon>
            <v-toolbar-title class="white--text text-uppercase font-weight-bold">Service PaySlips</v-toolbar-title>
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
        drawerItems: Menu()
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
