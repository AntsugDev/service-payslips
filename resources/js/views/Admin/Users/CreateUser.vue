<template>
    <v-app>
        <v-main>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <v-toolbar color="primary" dark flat dense>
                                <BackRoute name-router="ApplicationLogin"></BackRoute>
                                <SnackBarCommon></SnackBarCommon>
                                <v-toolbar-title color="secondary" class="font-weight-bold">CREA UTENTE</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" class="py-0">
                                            <v-form ref="formCreateUser" v-model="valid">
                                                <v-text-field :disabled="loading" color="primary" label="email" name="email"
                                                              v-model="form.email"
                                                              :rules="[value => !!value || 'Campo Obbligatorio', rules.email]"
                                                              type="email"></v-text-field>

                                                <v-text-field :disabled="loading" color="primary" label="cf/piva" name="code_user"
                                                              v-model="form.code_user"
                                                              :rules="[value => !!value || 'Campo Obbligatorio',rules.cf_piva]"
                                                              type="email"></v-text-field>

                                                <v-text-field :disabled="loading" color="primary" label="anagrafica" name="name"
                                                              v-model="form.name"
                                                              :rules="[value => !!value || 'Campo Obbligatorio']"
                                                              type="email"></v-text-field>


                                                <v-text-field
                                                    v-model="form.password"
                                                    :disabled="loading"
                                                    :rules="[value => !!value || 'Campo obbligatorio']"
                                                    label="Password"
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
                                                ></v-autocomplete>

                                            </v-form>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    variant="flat"
                                    color="primary" class="font-weight-bold" width="33%" @click="creaUser">
                                    Crea
                                </v-btn>
                            </v-card-actions>

                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>

import storeComputed from "../../../mixins/storeComputed.js";
import Companies from "../../../mixins/Companies.js";
import UsersApi from "../../../mixins/UsersApi.js";
import BackRoute from "../../Common/BackRoute.vue";
import SnackBarCommon from "../../Common/SnackBarCommon.vue";

export default {
    name: 'CreateUser',
    components: {SnackBarCommon, BackRoute},
    mixins:[storeComputed,Companies,UsersApi],
    data:() => ({
        loading: false,
        valid:false,
        listCompanies : [],
        form:{
            code_user: '',
            email: '',
            name:'',
            password: '',
            confirmPassword: '',
            company_id: ''
        },
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
                        value: element.id
                    })
                })
            })
        },
        creaUser: function () {
            this.loading = true;
            this.$refs.formCreateUser.validate().then(r => {
                if(r.valid){
                    delete this.form.confirmPassword;
                    this.createUser(this.form).then(r => {
                        this.$router.push({name:'ApplicationLogin',query:{logout: "Utente creato correttamente"}})
                        this.loading = false;
                    }).catch(e => {
                        this.loading = false;
                    })
                }
            })
        }
    },
    created() {
        this.getCompanies();
    }
}

</script>
