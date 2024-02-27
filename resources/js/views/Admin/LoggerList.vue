<template>
    <v-app>
        <v-container fluid class="fill-height align-content-start">
            <v-toolbar density="compact" flat color="primary" dark>
                <v-icon class="ml-2">
                    mdi-file-refresh
                </v-icon>
                <v-toolbar-title>Lista Logger</v-toolbar-title>
                <v-btn  icon="mdi-delete" alt="Cancella i log" title="Cancella i log"
                        depressed
                        @click="deleteLog">
                </v-btn>
            </v-toolbar>
            <v-data-table
                loading-text="Caricamento in corso..."
                class="elevation-1"
                :headers="headers"
                :items="items">
            </v-data-table>
        </v-container>
    </v-app>
</template>
<script>
import AdminApi from "../../mixins/AdminApi.js";

export default {
    name: "LoggerList",
    mixins:[AdminApi],
    data:() => ({
        headers:[
            {title:'Uuid',key:'id'},
            {title:'Nome',key:'name'},
            {title:'Tipologia',key:'type'},
            {title:'Messaggio',key:'msg'},
            {title:'Data',key:'date_insert'},
        ],
        items:[],
    }),
    methods:{
        listAll: function (){
            this.listLogger().then(r => {
                this.items = r.data.data;
            })
        },
        deleteLog:function (){
            this.delLogger().then(r => {
                this.$router.push({name:'UserIndex'})
            });
        }
    },
    created() {
        this.listAll();
    }
}
</script>
>
