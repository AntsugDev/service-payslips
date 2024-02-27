<template>

    <v-app>
        <v-container fluid class="fill-height align-content-start">
            <v-toolbar density="compact" flat color="primary" dark>
                <v-icon class="ml-2">
                    mdi-group
                </v-icon>
                <v-toolbar-title>Lista Groups</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn   depressed color="" @click="$router.push({ name: 'CreatePassSaveGroups' })">
                    <v-icon dark>mdi-plus</v-icon>
                    Crea nuovo
                </v-btn>
            </v-toolbar>

            <v-data-table
                loading-text="Caricamento in corso..."
                class="elevation-1"
                :loading="loading"
                :headers="headers"
                :items="listCategory">
                <template v-slot:[`item.actions`]="{ item }">

                    <v-btn
                        icon="mdi-delete"
                        density="compact"
                        color="red-darken-4"
                        alt="Cancellazione category"
                        title="Cancellazione category"
                        @click="$router.push({ name: 'DeleteGroups', params: { id: item.id } })">
                    </v-btn>
                </template>

            </v-data-table>

        </v-container>
    </v-app>

</template>
<script>
import Groups from "../../../mixins/PassSave/Groups.js";

export default {
    name: "ListPassSaveGroups",
    mixins:[Groups],
    data: () =>({
        loading:false,
        headers:[
            {title:'Id',key:'id'},
            {title:'Nome',key:'name'},
            {title:'Azioni',key:'actions'},
        ],
        listCategory:[]
    }),
    methods:{
        viewList: function (){
            this.lista().then(r => this.listCategory = r.data.data)
        }
    },
    created() {
        this.viewList();
    }
}
</script>
