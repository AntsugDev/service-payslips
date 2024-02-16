<template>
    <v-app>
        <router-view @userCreated="setUsers" @userEdited="setUsers" @userDeleted="setUsers"></router-view>
        <v-container fluid class="fill-height align-content-start">
            <v-toolbar density="compact" flat color="primary" dark>
                <v-icon class="ml-2">
                    mdi-account
                </v-icon>
                <v-toolbar-title>Users</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn depressed color="" @click="$router.push({ name: 'AdminCreateUser' })">
                    <v-icon dark>mdi-plus</v-icon>
                    Crea nuovo
                </v-btn>
            </v-toolbar>
            <v-data-table loading-text="Caricamento in corso..." class="elevation-1" :loading="getUsersRequest.loading"
                :headers="headers" :items="users">
                <template v-slot:[`item.role`]="{ item }">
                    <v-btn small dark :color="roleColor(item.role_id)">
                        {{ item.role.label }}
                    </v-btn>
                </template>
                <template v-slot:[`item.created_at`]="{ item }">
                    {{ formatDate(item.created_at) }}
                </template>
                <template v-slot:[`item.updated_at`]="{ item }">
                    {{ formatDate(item.updated_at) }}
                </template>
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn fab x-small color="primary" @click="$router.push({ name: 'AdminEditUser', params: { id: item.id } })"
                        class="mr-3">
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-btn fab x-small color="warning"
                        @click="$router.push({ name: 'AdminDeleteUser', params: { id: item.id } })">
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </template>
            </v-data-table>
        </v-container>
    </v-app>
</template>

<script>
import ResponseErrorHandler from "../../../mixins/ResponseErrorHandler";
import storeComputed from "../../../mixins/storeComputed";
import usersApi from "../../../mixins/UsersApi";
import moment from 'moment';

export default {
    name: "Users",
    mixins: [ResponseErrorHandler, storeComputed, usersApi],
    data: () => ({
        getUsersRequest: { loading: false },
        options: {},
        users: [],
        headers: [
            { title: "Id", key: "id" },
            { title: "Cognome", key: "last_name" },
            { title: "Nome", key: "first_name" },
            { title: "Email", key: "email" },
            { title: "Ruolo", key: "role" },
            { title: "Creato il", key: "created_at" },
            { title: "Ultima modifica", key: "updated_at" },
            { title: "Azioni", key: "actions", cellClass: 'text-no-wrap' }
        ]
    }),
    methods: {
        roleColor: function (value) {
            if (value === 1) {
                return "cyan";
            } else if (value === 2) {
                return "blue";
            } else {
                return "warning";
            }
        },
        formatDate(value) {
            return moment(value).format("DD/MM/YYYY HH:mm:ss");
        },
        setUsers: function () {
            this.getUsersRequest.loading = true;
            let params = {};
            this.getUsers(params).then(response => {
                this.users = response.data.data.map(user => {
                    return user.user;
                })
            }).catch(error => {
                this.handleResponseError(error);
            }).finally(() => {
                this.getUsersRequest.loading = false;
            })
        },
    },
    created() {
        this.setUsers();
    }
}
</script>
