<template>
    <v-app id="inspire">
        <SnackBarCommon></SnackBarCommon>
        <v-navigation-drawer
            app
            v-model="config.drawer"
            color="primary"
            :clipped="true"
            :mini-variant.sync="mini"
            expand-on-hover
            rail
            flat

        >
            <v-divider></v-divider>


            <template v-for="item in drawerItems">
                <v-list density="compact"
                        :opened="opened"
                        @update:opened="newOpened => opened = newOpened.slice(-1)"
                        v-if="item.children.length > 0"
                        nav
                >
                    <v-list-group v-model="item.active" >
                        <template v-slot:activator="{ props }">
                            <v-list-item
                                :key="item.text"
                                v-bind="props"
                                :title="item.text"
                                :prepend-icon="item.icon"
                            ></v-list-item>
                        </template>


                        <v-list-item
                            v-for="subMenu in item.children"
                            :key="subMenu"
                            :title="subMenu.text"
                            :prepend-icon="subMenu.icon"
                            :to="subMenu.routeName"
                        >
                            <v-list-item-icon></v-list-item-icon>
                        </v-list-item>
                    </v-list-group>
                </v-list>

                <v-list density="compact" v-else nav>
                    <v-list-item
                        :title="item.text"
                        :prepend-icon="item.icon"
                        :to="item.routeName"
                    ></v-list-item>
                </v-list>

            </template>




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
import {it} from "vuetify/locale";

export default {
    computed: {
        it() {
            return it
        }
    },
    components: {BtnLogout, SnackBarCommon},
    mixins: [storeComputed],
    name: "Home",
    data: () => ({
        mini: false,
        userMenu: false,
        drawerItems: Menu(),
        opened:[]
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
