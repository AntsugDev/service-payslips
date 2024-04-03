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

                                    <template v-if="!calling">
                                        <v-form ref="formCreateUser" :v-model="valid"  >
                                            <v-text-field :disabled="loading" color="primary" label="email" name="email" v-model="form.email" :rules="[value => !!value || 'Campo Obbligatorio', rules.email]" type="email"></v-text-field>
                                            <v-text-field :disabled="loading" color="primary" label="cf/piva" name="code_user" v-model="form.code_user" :rules="[value => !!value || 'Campo Obbligatorio',rules.cf_piva]" type="email" append-icon="mdi-smart-card" @click:append="randomFiscalCode"></v-text-field>
                                            <v-text-field :disabled="loading" color="primary" label="anagrafica" name="name"  v-model="form.name"  :rules="[value => !!value || 'Campo Obbligatorio']" type="email"></v-text-field>
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
                                        </v-form>
                                    </template>
                                    <template v-if="calling">
                                        <CreateCompany  ref="CreateCompanyForm"></CreateCompany>
                                    </template>

                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-divider dark></v-divider>
                    <v-card-actions >
                        <v-spacer></v-spacer>
                        <v-btn  color="info" variant="outlined" :disabled="loading" @click="$router.push({name:$route.query.route})">
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
    computed: {
    },
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
                                name: this.form.name,
                                type: this.$store.getters['user/getAdmin'] ? 'admin' : 'others'
                            }
                            this.createChildUser(payload).then(r => {
                                this.loading = false;
                                this.$router.push({name:this.$route.query.route,query:{esito: "ok"}})

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
            this.calling = this.$route.query.calling
        }
    }
}

</script>
