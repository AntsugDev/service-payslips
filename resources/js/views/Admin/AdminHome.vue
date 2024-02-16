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
        <v-app-bar color="primary" prominent>
            <v-app-bar-nav-icon variant="text" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Services Provisioning</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu v-model="userMenu" :close-on-content-click="true" :offset-y="true" bottom>
                <template v-slot:activator="{ props }">
                    <v-btn icon="mdi-account-circle" v-bind="props"></v-btn>
                </template>
                <v-card>
                    <v-list density="compact">
                        <v-list-item>
                            <template v-slot:prepend>
                                <v-icon icon="mdi-account"></v-icon>
                            </template>
                            <v-list-item-title>{{ user.firstName + ' ' + user.lastName }}</v-list-item-title>
                            <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>
                        </v-list-item>
                        <v-list-item>
                            <template v-slot:prepend>
                                <v-icon icon="mdi-cog"></v-icon>
                            </template>
                            <v-list-item-title>Ruolo</v-list-item-title>
                            <v-list-item-subtitle>{{ user.role.name }}</v-list-item-subtitle>
                        </v-list-item>
                    </v-list>
                    <v-divider></v-divider>
                    <v-list dense>
                        <v-list-item link @click="logout">
                            <v-list-item-title>Esci</v-list-item-title>
                        </v-list-item>
                    </v-list>
                </v-card>
            </v-menu>
        </v-app-bar>
        <v-navigation-drawer v-if="user.isAuthenticated" app v-model="drawer" color="primary" :clipped="true"
            :mini-variant.sync="mini" permanent>
            <v-list :lines="false" nav>
                <template v-for="item in drawerItems" :key="item.text">
                    <v-list-item :prepend-icon="item.icon" :title="item.text" :to="{ name: item.routeName }"
                        v-model="item.active" no-action color="white">
                    </v-list-item>
                </template>
            </v-list>
            <div v-if="user.role.name === 'root'">
                <v-divider></v-divider>
                <v-list :lines="false" nav>
                    <v-list-item prepend-icon="mdi-file-document-multiple-outline" title="Importazione massiva"
                        :to="{ name: 'MassImportIndex' }">
                    </v-list-item>
                    <v-list-group value="Jobs">
                        <template v-slot:activator="{ props }">
                            <v-list-item prepend-icon="mdi-pickaxe" v-bind="props" title="Jobs"></v-list-item>
                        </template>
                        <v-list-item v-for="([title, routeName], i) in jobsItems" :key="i" :title="title" :value="title"
                            :to="{ name: routeName }">
                        </v-list-item>
                    </v-list-group>
                </v-list>
            </div>
            <template v-slot:append>
                <div class="pa-2 mb-5">
                    <v-btn color="" block to='/api/documentation' target="_blank">
                        Documentation
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>
        <v-main>
            <v-container fluid class="fill-height align-content-start">
                <router-view v-if="user.isAuthenticated"></router-view>
            </v-container>
        </v-main>
    </v-app>
</template>


<script>
import storeComputed from "../../mixins/storeComputed";

export default {
    mixins: [storeComputed],
    name: "Home",
    data: () => ({
        drawer: null,
        mini: false,
        userMenu: false,
        jobsItems: [
            ['In Coda/Esecuzione', 'JobsIndex'],
            ['Falliti', 'FailedJobsIndex'],
        ],
        rootDrawerItems: [
            { text: "Users", icon: "mdi-account", routeName: "AdminUsersIndex" },
            { text: "Members", icon: "mdi-account-supervisor", routeName: "AdminMembersIndex" },
            { text: "Companies", icon: "mdi-factory", routeName: "AdminCompaniesIndex" },
            { text: "Partners", icon: "mdi-domain", routeName: "AdminPartnersIndex" },
            { text: "Services", icon: "mdi-format-list-group", routeName: "AdminServicesIndex" },
            {
                text: "Service subscriptions",
                icon: "mdi-format-list-group-plus",
                routeName: "AdminServiceSubscriptionsIndex"
            },
        ],
        adminDrawerItems: [
            { text: "Services", icon: "mdi-format-list-group", routeName: "AdminServicesIndex" },
            {
                text: "Service subscriptions",
                icon: "mdi-format-list-group-plus",
                routeName: "AdminServiceSubscriptionsIndex"
            },
        ],
    }),
    computed: {
        drawerItems: function () {
            if (!this.user.isAuthenticated) {
                return [];
            } else {
                if (this.user.role.name === 'root') {
                    return this.rootDrawerItems;
                } else {
                    return this.adminDrawerItems;
                }
            }
        }
    },
    methods: {
        logout: function () {
            localStorage.removeItem('pds-provisioning-token');
            this.$router.push({ name: 'ApplicationLogin' }).then(() => console.log('Logged out Successfully')).catch(e => console.log(e));
        },
    },
    beforeCreate() {
        if (localStorage.getItem('pds-provisioning-token')) {
            this.$store.commit('user/update', { jwtToken: localStorage.getItem('pds-provisioning-token') });
        }
    },
}
</script>

<style scoped></style>
