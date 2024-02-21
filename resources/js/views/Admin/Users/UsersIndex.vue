<template>
    <v-app>
        <router-view @userCreated="setUsers" @userEdited="setUsers" @userDeleted="setUsers"></router-view>
        <v-container fluid class="fill-height align-content-start">
            <v-toolbar density="compact" flat color="primary" dark>
                <v-icon class="ml-2">
                    mdi-account
                </v-icon>
                <v-toolbar-title>Dettaglio Utente</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn   depressed color="" @click="$router.push({ name: 'AdminCreateUser' })">
                    <v-icon dark>mdi-plus</v-icon>
                    Crea nuovo
                </v-btn>
            </v-toolbar>

            <v-data-table
                loading-text="Caricamento in corso..."
                class="elevation-1"
                :loading="getUsersRequest.loading"
                :headers="headers"
                :items="users">

                <template v-slot:[`item.role`]="{ item }">
                    <v-btn small dark :color="roleColor(item.role)">
                        {{ item.role }}
                    </v-btn>
                </template>

                <template v-slot:[`item.created_at`]="{ item }">
                    {{ formatDate(item.created_at) }}
                </template>

                <template v-slot:[`item.updated_at`]="{ item }">
                    {{ formatDate(item.updated_at) }}
                </template>

                <template v-slot:[`item.actions`]="{ item }">

                            <v-btn icon="mdi-lock-reset"
                                   density="compact"
                                   color="lime"
                                   alt="Modifica Password"
                                   title="Modifica Password"
                                   @click="$router.push({ name: 'EditPassword', params: { id: item.id } })">
                            </v-btn>

                            <v-btn icon="mdi-pencil"
                                   density="compact"
                                   color="primary"
                                   alt="Modifica Utenza"
                                   title="Modifica Utenza"
                                   @click="$router.push({ name: 'AdminEditUser', params: { id: item.id } })">
                            </v-btn>
                            <v-btn
                                v-if="(item.role === 'company')"
                                icon="mdi-delete"
                                density="compact"
                                color="warning"
                                @click="$router.push({ name: 'AdminDeleteUser', params: { id: item.id } })">
                            </v-btn>
                </template>


            </v-data-table>
        </v-container>
    </v-app>
</template>

<script>
import storeComputed from "../../../mixins/storeComputed";
import usersApi from "../../../mixins/UsersApi";
import moment from 'moment';

export default {
    name: "Users",
    mixins: [storeComputed, usersApi],
    data: () => ({
        getUsersRequest: { loading: false },
        options: {},
        users: [],
        headers: [
            { title: "Id", key: "id" },
            { title: "Nome", key: "name" },
            { title: "Codice Fiscale", key: "cf" },
            { title: "Email", key: "email" },
            { title: "Ruolo", key: "role" },
            { title: "Azienda", key: "company" },
            { title: "Creato il", key: "created_at" },
            { title: "Ultima modifica", key: "updated_at" },
            { title: "Azioni", key: "actions", cellClass: 'text-no-wrap' }
        ]
    }),
    methods: {
        roleColor: function (value) {
            if (value === 'user') {
                return "cyan";
            } else if (value === 'company') {
                return "blue";
            }
        },
        formatDate(value) {
            return moment(value).format("DD/MM/YYYY HH:mm:ss");
        },
        setUsers: function () {
            this.users = [this.$store.getters['user/getDatiUser']]
        },
    },
    created() {
        this.setUsers();
    }
}
</script>
