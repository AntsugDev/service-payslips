<template>

    <v-app>
        <v-container fluid class="fill-height align-content-start">
            <v-toolbar density="compact" flat color="primary" dark>
                <v-icon class="ml-2">
                    mdi-domain
                </v-icon>
                <v-toolbar-title>Lista Company</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn   depressed color="" @click="$router.push({ name: 'CreateUser',query:{calling: true,route:'ListCompany'} })">
                    <v-icon dark>mdi-plus</v-icon>
                    Crea nuovo
                </v-btn>
            </v-toolbar>

            <v-data-table
                loading-text="Caricamento in corso..."
                class="elevation-1"
                :loading="loading"
                :headers="headers"
                :items="companyList">
                <template v-slot:[`item.user_count`]="{ item }" >
                    <v-chip v-if="item.user_count > 0"
                            append-icon="mdi-account"
                            alt="Nr.utenti asseganti"
                            title="Nr.utenti asseganti"
                            :color="item.user_count%2 === 0 ? 'teal-darken-4' : 'yellow-darken-1'" variant="elevated">
                        {{ item.user_count }}
                    </v-chip>
                </template>



            </v-data-table>

        </v-container>
    </v-app>

</template>
<script>

import Companies from "../../../mixins/Companies.js";

export default {
    name: 'ListCompany',
    mixins: [Companies],
    data: () =>({
        loading: false,
        headers:  [
            { title: "Nome", key: "name" },
            { title: "Indirizzo", key: "address" },
            { title: "Città", key: "city.name" },
            { title: "Provincia", key: "city.provincie" },
            { title: "Regione", key: "city.region" },
            { title: "Email", key: "email" },
            { title: "Telefono", key: "phone" },
            { title: "Nr.Utenti", key: "user_count" },
        ],
        companyList: [],
    }),
    methods:{
        listCompany : function (){
            this.listAll().then(r => {
                let data = r.data.data;
                data.map(e => {
                    let row = e.company;
                    this.companyList.push(row)
                })
            })
        }
    },
    created() {
        this.listCompany()
    }
}

</script>
