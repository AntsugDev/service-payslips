<template>

    <v-app>
        <v-container fluid class="fill-height align-content-start">
            <v-toolbar density="compact" flat color="primary" dark>
                <v-icon class="ml-2">
                    mdi-account-group
                </v-icon>
                <v-toolbar-title>Lista Utenti</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn   depressed color="" @click="$router.push({ name: 'CreateUser',query:{calling: true,route:'ListUser'} })">
                    <v-icon dark>mdi-plus</v-icon>
                    Crea nuovo
                </v-btn>
            </v-toolbar>

            <v-data-table
                loading-text="Caricamento in corso..."
                class="elevation-1"
                :loading="loading"
                :headers="headers"
                :items="usersList">

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


                    <v-btn
                        icon="mdi-domain"
                        density="compact"
                        color="light-green-darken-1"
                        alt="Assegna/Modifica Azienda"
                        title="Assegna/Modifica Azienda"
                        @click="$router.push({ name: 'ChangeCompany', params: { id: item.id } })">
                    </v-btn>

                    <v-btn
                        icon="mdi-account-cancel"
                        density="compact"
                        color="deep-orange-darken-3"
                        alt="Cancella Utente"
                        title="Cancella Utente"
                        @click="$router.push({ name: 'AdminDeleteUser', params: { id: item.id } })">
                    </v-btn>


                </template>



            </v-data-table>



        </v-container>
    </v-app>

</template>
<script>
import moment from "moment/moment.js";
import AdminApi from "../../mixins/AdminApi.js";

export default {
    name: 'ListUser',
    mixins:[AdminApi],
    data: () => ({
        loading:false,
        usersList:[],
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
    methods:{
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
        listAllUsers:function (){
            this.listAllAdmin().then(r => {
                let data = r.data.data;
                data.map(e => {
                    let row = e.user
                    this.usersList.push({
                        id:row.id,
                        name: row.name,
                        code_user: row.code_user,
                        email:row.email,
                        role:row.role,
                        company:row.company !== null ? row.company.name: null,
                        created_at:row.created_at,
                        updated_at:row.updated_at,
                        password_at:row.password_at
                    })
                })
            })
        }
    },
    created() {
        this.listAllUsers();
    }
}
</script>
