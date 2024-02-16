<template>
    <v-dialog v-model="dialog" persistent max-width="600">
        <v-card>
            <v-toolbar dark flat color="primary" height="dense">
                <v-toolbar-title class="text-center">
                    <h5 class="text-uppercase font-weight-regular text-wrap" style="letter-spacing: 2px">
                        Modifica dati utente
                    </h5>
                </v-toolbar-title>
            </v-toolbar>
            <v-progress-linear indeterminate color="primary" v-if="getSelectedUserRequest.loading"></v-progress-linear>
            <v-card-text v-else>
                <UserForm ref="userForm" :selectedUser="selectedUser"></UserForm>
            </v-card-text>
            <v-divider dark></v-divider>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="$router.push({ name: 'AdminUsersIndex' })">
                    chiudi
                </v-btn>
                <v-btn color="primary" :loading="getUsersRequest.loading" @click="setUsers">
                    salva
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import ResponseErrorHandler from "../../../mixins/ResponseErrorHandler";
import UserForm from "./Form/UserForm.vue";
import storeComputed from "../../../mixins/storeComputed";
import usersApi from "../../../mixins/UsersApi";

export default {
    name: "EditUser",
    mixins: [ResponseErrorHandler, storeComputed, usersApi],
    components: { UserForm },
    data: () => ({
        getSelectedUserRequest: { loading: false },
        getUsersRequest: { loading: false },
        userId: null,
        selectedUser: {},
        options: {},
        dialog: true
    }),
    methods: {
        setUsers: function () {
            if (this.$refs.userForm.$refs.form.validate()) {
                this.getUsersRequest.loading = true;
                if (!this.$refs.userForm.enabledPassword) {
                    delete this.$refs.userForm.userData.password;
                    delete this.$refs.userForm.userData.password_confirmation
                }
                this.patchSelectedUser(this.userId, this.$refs.userForm.userData).then(response => {
                    this.$emit('userEdited');
                    this.$store.commit('snackbar/update', {
                        show: true,
                        color: 'success',
                        text: 'Utente aggiornato con successo'
                    });
                    this.$router.push({ name: 'AdminUsersIndex' });
                }).catch(error => {
                    this.handleResponseError(error);
                }).finally(() => {
                    this.getUsersRequest.loading = false;
                })
            }
        },
        setSelectedUser: function () {
            this.getSelectedUserRequest.loading = true;
            let params = {};
            this.getUsers(params, this.userId).then(response => {
                this.selectedUser = response.data.data.user;
            }).catch(error => {
                this.handleResponseError(error);
            }).finally(() => {
                this.getSelectedUserRequest.loading = false;
            })
        },
    },
    created() {
        this.userId = this.$route.params.id;
        this.setSelectedUser();
    }
}
</script>
