<template>
    <v-app id="inspire">
        <v-snackbar v-model="snackbar.show" top :color="snackbar.color" :timeout="3000" dense>
            {{ snackbar.text }}
            <template v-slot:action="{ attrs }">
                <v-btn :color="snackbar.color" fab x-small dark v-bind="attrs"
                       @click="$store.commit('snackbar/update', { show: false })" class="elevation-6">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </template>
        </v-snackbar>

        <v-navigation-drawer app v-model="drawer" color="primary" :clipped="true" :mini-variant.sync="mini" permanent flat>
            <v-list dense dark>
                <template v-for="item in drawerItems">
                    <v-list-item v-if="item.children.length === 0" :key="item.text" :to="{ name: item.routeName }">
                        <v-list-item-icon>
                            <v-icon >{{item.icon}}</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title class="white--text font-weight-bold text-wrap">
                                {{ item.text }}
                            </v-list-item-title>
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
            <v-app-bar-nav-icon @click.stop="mini = !mini" class="primary white--text"></v-app-bar-nav-icon>
            <v-toolbar-title class="white--text text-uppercase font-weight-bold">Service PaySlips</v-toolbar-title>
            <v-spacer></v-spacer>
                <v-btn
                    stacked
                    icon="mdi-logout"
                    size="x-small"
                    alt="Logout"
                    title="Logout"
                    @click="logout">
                </v-btn>
        </v-app-bar>
        <v-main>

            <router-view></router-view>
        </v-main>
    </v-app>
</template>

<script>


import storeComputed from "../mixins/storeComputed.js";

export default {
    mixins: [storeComputed],
    name: "Home",
    data: () => ({
        drawer: null,
        mini: false,
        userMenu: false,
        drawerItems: [
            { text: "Dettaglio Utente", icon: "mdi-account", routeName: "UserIndex", children: [] },
            // {
            //     text: "Data Management",
            //     icon: "mdi-database",
            //     children: [
            //         { text: "Importa File", routeName: "" },
            //         { text: "Vedi lista cedolini", routeName: "" },
            //     ]
            // },
            // {
            //     text: "Jobs", icon: "mdi-pickaxe", children: [
            //         { text: "In Coda/Esecuzione", routeName: "" },
            //         { text: "Falliti", routeName: "" }
            //     ]
            // }
        ],
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
