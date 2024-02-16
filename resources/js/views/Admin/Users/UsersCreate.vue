<template>
    <v-dialog v-model="dialog" persistent max-width="600">
        <v-card>
            <v-toolbar dark flat color="primary" height="dense">
                <v-toolbar-title class="text-center">
                    <h5 class="text-uppercase font-weight-regular text-wrap" style="letter-spacing: 2px">
                        Aggiunta nuovo utente
                    </h5>
                </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                <UserForm ref="userForm"></UserForm>
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
import UserForm from "./Form/UserForm.vue";
import storeComputed from "../../../mixins/storeComputed";
import ResponseErrorHandler from "../../../mixins/ResponseErrorHandler";
import usersApi from "../../../mixins/UsersApi";

export default {
    name: "CreateUser",
    components: { UserForm },
    mixins: [ResponseErrorHandler, storeComputed, usersApi],
    data: () => ({
        getUsersRequest: { loading: false },
        dialog: true
    }),
    methods: {
        setUsers: function () {
            if (this.$refs.userForm.$refs.form.validate()) {
                this.getUsersRequest.loading = true;
                this.postUser(this.$refs.userForm.userData)
                    .then(response => {
                        this.$emit('userCreated');
                        this.$store.commit('snackbar/update', {
                            show: true,
                            color: 'success',
                            text: 'Utente aggiunto con successo'
                        });
                        this.$router.push({ name: 'AdminUsersIndex' });
                    })
                    .catch(error => {
                        this.handleResponseError(error);
                    })
                    .finally(() => {
                        this.getUsersRequest.loading = false;
                    })
            }
        },
    }
}
</script>
