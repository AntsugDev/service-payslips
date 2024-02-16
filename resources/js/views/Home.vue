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
        <v-main>
            <v-container class="fill-height justify-center" v-if="!user.isAuthenticated">
                <v-progress-circular :size="50" color="primary" indeterminate></v-progress-circular>
            </v-container>
            <router-view v-else></router-view>
        </v-main>
    </v-app>
</template>

<script>
import StoreComputed from "../mixins/storeComputed";
import whoAmIApi from "../mixins/WhoAmIApi";
import responseErrorHandler from "../mixins/ResponseErrorHandler";

export default {
    mixins: [StoreComputed, whoAmIApi, responseErrorHandler],
    name: "Home",
    data: () => ({
        getWhoAmIRequest: { loading: true }
    }),
    watch: {
        'user': {
            handler(user) {
                // if (user.role.id === 1) {
                this.$router.push({ name: 'AdminHome' })
                // } else if (user.role.id === 4) {
                // this.$router.push({ name: 'HelpdeskHome' })
                // }
            },
            deep: true
        }
    },
    beforeCreate() {
        if (localStorage.getItem('pds-provisioning-token')) {
            this.$store.commit('user/update', { jwtToken: localStorage.getItem('pds-provisioning-token') });
        } else {
            this.$router.push({ name: 'ApplicationLogin' });
        }
    },
    created() {
        this.getWhoAmI()
            .then(response => {
                this.$store.commit('user/update', {
                    isAuthenticated: true,
                    firstName: response.data.data.user.first_name,
                    lastName: response.data.data.user.last_name,
                    email: response.data.data.user.email,
                    role: response.data.data.user.role,
                    jwtToken: response.data.data.user.jwtToken,
                });
            })
            .catch(error => {
                this.handleResponseError(error)
            })
            .finally(() => {
                this.getWhoAmIRequest.loading = false
            })
    }
}
</script>

<style scoped></style>
