<template>
    <v-dialog v-model="dialog" persistent max-width="600">
        <v-card>
            <v-toolbar dark flat color="primary" height="dense">
                <v-toolbar-title class="text-center">
                    <h5 class="text-uppercase font-weight-regular text-wrap" style="letter-spacing: 2px">
                        Aggiungi/Modifica Company
                    </h5>
                </v-toolbar-title>
            </v-toolbar>
            <v-card-text>

                <v-row  align-content="center">
                    <v-col cols="12" align-self="end" >
                        <v-chip  v-if="actualCompany !== null" prepend-icon="mdi-domain" color="info" variant="elevated">
                            COMPANY: {{ actualCompany }}
                        </v-chip>
                        <v-chip prepend-icon="mdi-email" color="indigo" variant="elevated">
                            USER: {{ email }}
                        </v-chip>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12"></v-col>
                </v-row>
                <v-row>
                    <v-col cols="12">
                        <v-autocomplete
                            label="Aziende"
                            :items="listCompanies"
                            v-model="form.company_id"
                            dense
                            item-title="text"
                            item-value="value"
                            :rules="[value => !!value || 'Campo obbligatorio']"
                            clearable
                        ></v-autocomplete>

                    </v-col>
                </v-row>


            </v-card-text>
            <v-divider dark></v-divider>
            <v-card-actions >
                <v-spacer></v-spacer>
                <v-progress-circular indeterminate color="dark" v-if="loading"></v-progress-circular>
                <v-btn :disabled="loading" color="info" variant="outlined" @click="$router.push({ name: 'ListUser' })">
                    chiudi
                </v-btn>
                <v-btn color="success" variant="outlined"  :disabled="loading" @click="assegnaUserCompany">
                    {{actualCompanyId !== null ? 'modifica' : 'assegna'}}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script >
import Companies from "../../../mixins/Companies.js";
import AdminApi from "../../../mixins/AdminApi.js";

export default {
    name: 'ChangeCompany',
    mixins:[Companies,AdminApi],
    data: () => ({
        dialog:true,
        loading:false,
        listCompanies: [],
        form:{
            company_id: '',
            user_id: null
        },
        actualCompany: null,
        actualCompanyId: null,
        email: null
    }),
    methods:{
        geListCompanies: function (){
            this.listAll().then(r => {
                let data = r.data.data;
                data.map(e => {
                    let element = e.company
                    this.listCompanies.push({
                        text: `${element.name}`+' '+`${element.address}`,
                        value: element.id,
                    })
                })
            })
        },
        getDetailsUser:function (){
            this.detailsUser(this.$route.params.id).then(r =>{
                let data = r.data.user
                if(data.company !== null){
                    this.actualCompany   = data.company.name
                    this.actualCompanyId = data.company_id
                    if(this.actualCompanyId !== null)
                        this.listCompanies = this.listCompanies.filter(e => {
                            return e.value !== this.actualCompanyId
                        })
                }
                this.email        = data.email;
                this.form.user_id = this.$route.params.id
            })
        },
        assegnaUserCompany: function (){
            this.updateUserCompany(this.form.user_id,this.form.company_id).then(r => {
                this.$router.push({name:'ListUser'})
            })
        }
    },
    created() {
        this.geListCompanies()
        this.getDetailsUser();
    }
}
</script>
