<template>
    <v-app>
        <v-main>
            <v-dialog v-model="dialog" persistent max-width="600">
                <v-card>
                    <v-toolbar dark flat color="primary" height="dense">
                        <BackRoute v-if="!calling"  name-router="ApplicationLogin"></BackRoute>
                        <v-toolbar-title class="text-center">
                            <h5 class="text-uppercase font-weight-regular text-wrap" style="letter-spacing: 2px">
                                CREA
                            </h5>
                        </v-toolbar-title>
                    </v-toolbar>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12" class="py-0">
                                    <v-tabs v-if="!calling"
                                        fixed-tabs
                                        bg-color="indigo-lighten-1"
                                    >
                                        <v-tab v-for="(e,i) in tabs" :key="i" :value="i" @click="changeTab(i)" >{{e}}</v-tab>
                                    </v-tabs>
                                    <v-spacer></v-spacer>
                                    <v-divider></v-divider>
                                    <v-spacer></v-spacer>

                                    <v-window v-model="tab">
                                        <v-window-item
                                            value="0"
                                        >
                                            <v-form ref="formCreateUser" :v-model="valid">
                                                <v-text-field :disabled="loading" color="primary" label="email" name="email" v-model="form.email" :rules="[value => !!value || 'Campo Obbligatorio', rules.email]" type="email"></v-text-field>
                                                <v-text-field :disabled="loading" color="primary" label="cf/piva" name="code_user" v-model="form.code_user" :rules="[value => !!value || 'Campo Obbligatorio',rules.cf_piva]" type="email" append-icon="mdi-smart-card" @click:append="randomFiscalCode"></v-text-field>
                                                <v-text-field :disabled="loading" color="primary" label="anagrafica" name="name"  v-model="form.name"  :rules="[value => !!value || 'Campo Obbligatorio']" type="email"></v-text-field>
                                                <template v-if="!calling">
                                                    <v-text-field  v-model="form.password" :disabled="loading" :rules="[value => !!value || 'Campo obbligatorio']"  label="Password"
                                                                   :type="show.newPassword ? 'text' : 'password'"
                                                                   :append-icon="show.newPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                                                   @click:append="show.newPassword = !show.newPassword"
                                                    ></v-text-field>
                                                    <v-text-field
                                                        v-model="form.confrimPassword"
                                                        :disabled="loading"
                                                        :rules="[value => !!value || 'Campo obbligatorio',form.confrimPassword === form.password || 'Le due password non corrispondono']"
                                                        label="Conferma Password"
                                                        :type="show.confrimPassword ? 'text' : 'password'"
                                                        :append-icon="show.confrimPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                                        @click:append="show.confrimPassword = !show.confrimPassword"
                                                        :error-messages="error"
                                                    ></v-text-field>

                                                    <v-autocomplete
                                                        label="Aziende"
                                                        :items="listCompanies"
                                                        v-model="form.company_id"
                                                        dense
                                                        item-title="text"
                                                        item-value="value"
                                                        :rules="[value => !!value || 'Campo obbligatorio']"
                                                        clearable
                                                        :disabled="calling"
                                                    ></v-autocomplete>
                                                </template>
                                            </v-form>

                                        </v-window-item>
                                        <v-window-item
                                            v-if="!calling"
                                            value="1"
                                        >
                                            <CreateCompany ref="CreateCompanyForm"></CreateCompany>
                                        </v-window-item>
                                    </v-window>

                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-divider dark></v-divider>
                    <v-card-actions >
                        <v-spacer></v-spacer>
                        <v-btn v-if="calling" color="info" variant="outlined" :disabled="loading" @click="$router.push({name:'UserIndex'})">
                            Chiudi
                        </v-btn>
                        <v-progress-circular indeterminate color="dark" v-if="loading"></v-progress-circular>
                        <v-btn color="success" variant="outlined" :disabled="loading" @click="creaUser">
                            Crea
                        </v-btn>
                    </v-card-actions>
                </v-card>

            </v-dialog>
        </v-main>
    </v-app>
</template>

<script>

import storeComputed from "../../../mixins/storeComputed.js";
import Companies from "../../../mixins/Companies.js";
import UsersApi from "../../../mixins/UsersApi.js";
import BackRoute from "../../Common/BackRoute.vue";
import SnackBarCommon from "../../Common/SnackBarCommon.vue";
import CreateCompany from "./CreateCompany.vue";

export default {
    name: 'CreateUser',
    components: {CreateCompany, SnackBarCommon, BackRoute},
    mixins:[storeComputed,Companies,UsersApi],
    data:() => ({
        dialog:true,
        loading: false,
        valid:false,
        listCompanies : [],
        calling: false,
        form:{
            code_user: '',
            email: '',
            name:'',
            password: '',
            confirmPassword: '',
            company_id: '',
        },
        tabs:[
            "Utente","Company"
        ],
        tab:0,
        rules: {
            email: value => {
                const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                return pattern.test(value) || 'Devi inserire un indirizzo email valido'
            },
            cf_piva: value => {
                const pattern = /[A-Za_z0-9]/
                return value.length >=10 && value.length <=17 && pattern.test(value) || "La lunghezza della stringa deve essere compresa tra 11 e 16 e deve contennere lettere e numeri"
            }
        },
        error: null,
        show:{
            password: false,
            confrimPassword: false
        },

    }),
    methods:{
        getCompanies: function (){
            this.listCompanies = [];
            this.listAll().then(r => {
                let data = r.data.data;
                data.map(e => {
                    let element = e.company
                    this.listCompanies.push({
                        text: `${element.name}`+' '+`${element.address}`+ ','+`${element.city}`,
                        value: element.id,
                    })
                })
            })
        },
        creaUser: function () {
            this.loading = true;
            if(this.tab === 0) {

                this.$refs.formCreateUser.validate().then(r => {
                    if(r.valid){

                        if(!this.calling){
                            console.log('caaaa',this.tab)

                            delete this.form.confirmPassword;
                            this.createUser(this.form).then(r => {
                                this.$router.push({
                                    name: 'ApplicationLogin',
                                    query: {logout: "Utente creato correttamente"}
                                })
                                this.loading = false;
                            }).catch(e => {
                                this.loading = false;
                            })
                        }else{
                            let payload = {
                                email: this.form.email,
                                code_user: this.form.code_user,
                                name: this.form.name
                            }
                            this.createChildUser(payload).then(r => {
                                this.loading = false;
                                this.$router.push({name:'UserIndex',query:{esito: "ok"}})

                            }).catch(e => {
                                this.loading = false;
                            })
                        }

                    }else
                        this.loading = false;
                })

            }else{
                if(this.$refs.CreateCompanyForm.valid){
                    this.createCompany(this.$refs.CreateCompanyForm.form).then(r =>{
                        this.loading = false;
                        this.$router.push({
                            name: 'ApplicationLogin',
                            query: {logout: "Utente e Company create correttamente"}
                        })
                    }).catch(e => {
                        this.loading = false;
                    })
                }
            }

        },
        randomFiscalCode: function (){
            this.generateFiscalCode().then(r => {
                this.form.code_user = r.data.data
            })
        },
        changeTab: function (i){
            this.tab = i
        }
    },
    created() {
        this.getCompanies();
        if(this.$route.query.calling !== undefined) {
            this.calling = true
        }
    }
}

</script>
