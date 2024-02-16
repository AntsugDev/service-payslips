<template>
    <v-app>
        <v-main>
            <v-container class="fill-height" fluid>

                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <v-toolbar color="primary" dark flat dense>
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
                    console.log('ok',JSON.stringify(res))
                }).catch(error => {
                    let errorText = error.response.data
                    this.$store.commit('snackbar/update', {
                        show: true,
                        color: 'waring',
                        text: errorText
                    });
                }).finally(() => {
                    this.loading = false;
                });
                //     this.loading = false;
                //     localStorage.setItem('pds-provisioning-token', res.data.access_token);
                //
                //
                //
                //
                //     this.$router.push({ name: 'Home' }).then(() => console.log('Successfully Logged In')).catch(e => console.log(e));
                // }).catch(e => {
                //     if (e.response === undefined) {
                //
                //     } else {
                //         let status = e.response.status;
                //         switch (status.toString().charAt(0)) {
                //             case '5':
                //                 this.$store.commit('snackbar/update', {
                //                     show: true,
                //                     color: 'error',
                //                     text: "Credenziali non valide"
                //                 });
                //                 break;
                //             case '4':
                //                 this.$store.commit('snackbar/update', {
                //                     show: true,
                //                     color: 'error',
                //                     text: 'Credenziali non valide'
                //                 });
                //                 break;
                //             default:
                //                 this.$store.commit('snackbar/update', {
                //                     show: true,
                //                     color: 'error',
                //                     text: e.toString()
                //                 });
                //                 break;
                //         }
                //     }
                // }).finally(() => {
                //     this.loading = false;
                // });
            }
        }
    },
    computed: {
        config: function () {
            return this.$store.state.config;
        }
    }
}
</script>

<style scoped></style>
