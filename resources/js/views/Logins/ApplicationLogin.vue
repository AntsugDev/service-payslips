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

                                <v-snackbar v-model="snackbar.show" top :color="snackbar.color" :timeout="3000" dense>
                                    {{ snackbar.text }}
                                    <template v-slot:actions>
                                        <v-btn :color="snackbar.color" fab x-small dark
                                               @click="$store.commit('snackbar/update', { show: false })" class="elevation-6">
                                            <v-icon>mdi-close</v-icon>
                                        </v-btn>
                                    </template>
                                </v-snackbar>
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
                                                              type="password"></v-text-field>
                                            </v-form>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" class="font-weight-bold" width="100%" dark @click="login"
                                       :disabled="loading">
                                    Accedi
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
import storeComputed from "../../mixins/storeComputed";
import UsersApi from "../../mixins/UsersApi.js";
import {th} from "vuetify/locale";

export default {
    name: "ApplicationLogin",
    mixins: [storeComputed,UsersApi],
    data() {
        return {
            alert:null,
            valid: true,
            email: '',
            password: '',
            loading: false,
            rules: {
                email: value => {
                    const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    return pattern.test(value) || 'Devi inserire un indirizzo email valido'
                },
            },
            snackbar:{
                show:false,
                color: null,
                text:null
            }

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
                })
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
            this.alert = this.$route.query.logout
            setTimeout(() => {
                this.alert = null
            },5000)
        }
    }
}
</script>

<style scoped></style>
