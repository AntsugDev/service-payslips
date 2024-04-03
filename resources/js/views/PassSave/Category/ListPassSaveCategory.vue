<template>

    <v-app>
        <v-container fluid class="fill-height align-content-start">
            <v-toolbar density="compact" flat color="primary" dark>
                <v-icon class="ml-2">
                    mdi-application-cog
                </v-icon>
                <v-toolbar-title>Lista Categorie</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn   depressed color="" @click="$router.push({ name: 'CreatePassSaveCategory' })">
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

                <template v-slot:[`item.fields`]="{ item }">
                    <v-list dense>
                        <v-list-item v-for="(e,i) in item.fields" :key="i">
                            <v-list-item-content>
                                <v-list-item-title>{{e.title}}</v-list-item-title>
                                <v-list-item-subtitle>{{e.description}} - {{e.type}} </v-list-item-subtitle>
                                <v-divider></v-divider>
                            </v-list-item-content>

                        </v-list-item>
                    </v-list>

                </template>

                <template v-slot:[`item.actions`]="{ item }">

                    <v-btn
                        icon="mdi-delete"
                        density="compact"
                        color="red-darken-4"
                        alt="Cancellazione category"
                        title="Cancellazione category"
                        @click="$router.push({ name: 'DeleteCategory', params: { id: item.id } })">
                    </v-btn>
                </template>

            </v-data-table>

        </v-container>
    </v-app>

</template>
<script>
import Category from "../../../mixins/PassSave/Category.js";

export default {
    name: "ListPassSaveCategory",
    mixins:[Category],
    data: () =>({
        loading:false,
        headers:[
            {title:'Id',key:'id'},
            {title:'Nome',key:'name'},
            {title:'Fields',key:'fields'},
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
