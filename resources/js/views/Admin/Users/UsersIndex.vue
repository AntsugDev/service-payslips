<template>
    <v-app>
        <v-container fluid class="fill-height align-content-start">
            <v-toolbar density="compact" flat color="primary" dark>
                <v-icon class="ml-2">
                    mdi-account
                </v-icon>
                <v-toolbar-title>Dettaglio Utente</v-toolbar-title>
                <v-spacer></v-spacer>
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
                    {{ item.created_at !== null ? formatDate(item.created_at) : ""}}
                </template>

                <template v-slot:[`item.updated_at`]="{ item }">
                    {{ item.updated_at !== null ? formatDate(item.updated_at) : "" }}
                </template>

                <template v-slot:[`item.actions`]="{ item }" v-if="!admin">

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
                        v-if="(item.role === 'user')"
                        icon="mdi-account-cancel"
                        density="compact"
                        color="light-green"
                        @click="$router.push({ name: 'AdminDeleteUser', params: { id: item.id } })">
                    </v-btn>

                    <v-btn
                        v-if="item.company === undefined"
                        icon="mdi-account-arrow-right"
                        density="compact"
                        color="blue-grey"
                        alt="Entra con questa utenza"
                        title="Entra con questa utenza"
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
import Companies from "../../../mixins/Companies.js";
import store from "../../../store/index.js";
import user from "../../../store/modules/User.js";

export default {
    name: "Users",
    computed: {
        user() {
            return user
        }
    },
    mixins: [storeComputed, usersApi,Companies],
    data: () => ({
        getUsersRequest: { loading: false },
        options: {},
        users: [],
        base64:null,
        role: null,
        admin:false,
        headers: [
            { title: "Nome", key: "name" },
            { title: "Codice Fiscale/PIVA", key: "code_user" },
            { title: "Email", key: "email" },
            { title: "Ruolo", key: "role" },
            { title: "Azienda", key: "company" },
            { title: "Creato il", key: "created_at" },
            { title: "Ultima modifica", key: "updated_at" },
            { title: "Password modificata il", key: "password_at" },
            { title: "Azioni", key: "actions", cellClass: 'text-no-wrap' }
        ],

    }),
    methods: {
        roleColor: function (value) {
            if (value === 'User') {
                return "indigo-lighten-3";
            } else if (value === 'Company') {
                return "green-lighten-1";
            }
            else if (value === 'Admin') {
                return "red-lighten-1";
            }
            else if (value === 'User-child') {
                return "teal-lighten-5";
            }
        },
        formatDate(value) {
            return moment(value).format("DD/MM/YYYY HH:mm:ss");
        },
        setUsers: function () {
            this.users = [this.$store.getters['user/getDatiUser']]
        },
        listUserChildren : function (){
            this.childrenUser().then(r => {
                let data = r.data.data;
                data.map(e => {
                    let row = e.user
                    this.users.push(row)
                })
            })
        },

    },
    created() {
        this.setUsers();
        this.listUserChildren()
        if(store.getters['user/getAdmin']){
            this.admin = true
        }
    }
}
</script>
