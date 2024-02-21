<template>
    <v-app>
        <v-main>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <v-toolbar color="primary" dark flat dense>


                                <v-snackbar v-model="snackbar.show" top :color="snackbar.color" :timeout="3000" dense>
                                    {{ snackbar.text }}
                                    <template v-slot:action="{ attrs }">
                                        <v-btn :color="snackbar.color" fab x-small dark v-bind="attrs"
                                               @click="$store.commit('snackbar/update', { show: false })" class="elevation-6">
                                            <v-icon>mdi-close</v-icon>
                                        </v-btn>
                                    </template>
                                </v-snackbar>
                                <v-icon alt="Torna alla login" title="Torna alla login" @click="$router.push({name:'ApplicationLogin'})">mdi-keyboard-backspace</v-icon>
                                <v-toolbar-title color="secondary" class="font-weight-bold">CREA UTENTE</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" class="py-0">
                                            <v-form ref="formCreateUser" v-model="valid">
                                            </v-form>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    variant="flat"
                                    color="primary" class="font-weight-bold" width="33%">
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

export default {
    name: 'CreateUser',
    mixins:[storeComputed],
    data:() => ({
        valid:false
    })
}

</script>
