<template>
    <v-dialog v-model="dialog" persistent max-width="600">
        <v-card>
            <v-toolbar dark flat color="primary" height="dense">
                <v-toolbar-title class="text-center">
                    <h5 class="text-uppercase font-weight-regular text-wrap" style="letter-spacing: 2px">
                        Elimina utente
                    </h5>
                </v-toolbar-title>
            </v-toolbar>
            <v-card-text class="mt-3">
                <b>Attenzione!</b> Si sta tentando di eliminare un utente
            </v-card-text>
            <v-divider dark></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="$router.push({ name: 'AdminUsersIndex' })">
                    chiudi
                </v-btn>
                <v-btn color="primary" @click="setUsers" :loading="getUsersRequest.loading">
                    Elimina
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import ResponseErrorHandler from "../../../mixins/ResponseErrorHandler";
import storeComputed from "../../../mixins/storeComputed";
import usersApi from "../../../mixins/UsersApi";

export default {
    name: "DeleteUser",
    mixins: [ResponseErrorHandler, storeComputed, usersApi],
    data: () => ({
        getUsersRequest: { loading: false },
        userId: null,
        dialog: true
    }),
    methods: {
        setUsers: function () {
            this.getUsersRequest.loading = true;
            this.deleteUser(this.userId).then(response => {
                this.$emit("userDeleted");
                this.$store.commit('snackbar/update', {
                    show: true,
                    color: 'success',
                    text: "Utente eliminato con successo"
                });
                this.$router.push({ name: 'AdminUsersIndex' });
            }).catch(error => {
                this.handleResponseError(error);
            }).finally(() => {
                this.getUsersRequest.loading = false;
            })
        },

    },
    created() {
        this.userId = this.$route.params.id;
    }
}
</script>
