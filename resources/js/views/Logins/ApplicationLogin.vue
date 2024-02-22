<template>
    <v-app>
        <v-main>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <template v-if="alert  !== null">
                                <v-alert  color="info">{{alert}}</v-alert>
                                <v-divider></v-divider>
                            </template>
                            <v-toolbar color="primary" dark flat dense>
                                <SnackBarCommon></SnackBarCommon>
                                <v-toolbar-title color="secondary" class="font-weight-bold">ACCESSO</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" class="py-0">
                                            <v-form ref="form" v-model="valid">
                                                <v-text-field :disabled="loading" color="primary" label="email" name="email"
                                                              prepend-icon="mdi-at" v-model="email"
                                                              :rules="[value => !!value || 'Devi inserire l\'email', rules.email]"
                                                              type="email"></v-text-field>
                                                <v-text-field :disabled="loading" color="primary" id="password"
                                                              label="Password" name="password" prepend-icon="mdi-lock"
                                                              v-model="password"
                                                              :rules="[value => !!value || 'Devi inserire la password']"
                                                              :type="show.password ? 'text' : 'password'"
                                                              :append-icon="show.password ? 'mdi-eye' : 'mdi-eye-off'"
                                                              @click:append="show.password = !show.password"
                                                ></v-text-field>
                                            </v-form>
                                        </v-col>
                                    </v-row>
                                </v-container>
                                <v-divider></v-divider>
                            </v-card-text>
                            <v-card-actions>
                                <v-container>
                                    <v-row dense>
                                        <v-col cols="12">
                                            <v-btn
                                                variant="outlined"
                                                color="primary" class="font-weight-bold"
                                                width="100%"
                                                @click="login"
                                                :disabled="loading">
                                                Accedi
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                    <v-row dense justify="space-between">
                                        <v-col cols="6">
                                            <v-btn
                                            variant="outlined"
                                            color="info"
                                            class="font-weight-bold"
                                            width="100%"
                                            @click="$router.push({name: 'CreateUser'})"
                                            :disabled="loading">
                                            Crea utenza/company
                                        </v-btn></v-col>
                                        <v-col cols="6">
                                            <v-btn
                                                variant="outlined"
                                                color="warning"
                                                class="font-weight-bold"
                                                width="100%"
                                                @click="$router.push({name: 'ResetPassword'})"
                                                :disabled="loading">
                                                Reset Password
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import storeComputed from "../../mixins/storeComputed";
import UsersApi from "../../mixins/UsersApi.js";
import {th} from "vuetify/locale";
import SnackBarCommon from "../Common/SnackBarCommon.vue";

export default {
    name: "ApplicationLogin",
    components: {SnackBarCommon},
    mixins: [storeComputed,UsersApi],
    data() {
        return {
            alert:null,
            valid: true,
            email: 'antonio.sugamele@gmail.com',
            password: '@AntSug1983@',
            loading: false,
            rules: {
                email: value => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    return pattern.test(value) || 'Devi inserire un indirizzo email valido'
                },
            },
            show:{
                password:false
            },
        }
    },
    methods: {
        validateForm: function () {
            this.$refs.form.validate()
        },
        login: function () {
            this.validateForm();
            if (this.valid) {
                this.loading = true;
                let data = {
                    email: this.email,
                    password: this.password
                }
                this.loginEnter(data).then(res => {
                    this.loading = false;
                    let response = res.data
                    this.$store.commit('user/create',response)
                    this.$router.push({name:'Home'});
                }).catch(e =>{
                        this.loading = false;
                    }
                )
            }
        }
    },
    computed: {
        config: function () {
            return this.$store.state.config;
        },
    },
    mounted() {
        if(this.$route.query.logout !== undefined){
            this.$store.commit('snackbar/update',{
                show: true,
                text: this.$route.query.logout,
                color: 'info'
            })
        }
    }
}
</script>

<style scoped></style>
