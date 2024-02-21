<template>
    <v-app>
        <v-main>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <v-snackbar v-model="snackbar.show" top :color="snackbar.color" :timeout="3000" dense>
                                {{ snackbar.text }}
                                <template v-slot:action="{ attrs }">
                                    <v-btn :color="snackbar.color" fab x-small dark v-bind="attrs"
                                           @click="$store.commit('snackbar/update', { show: false })" class="elevation-6">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                </template>
                            </v-snackbar>
                            <v-toolbar color="primary" dark flat dense>
                                <v-icon alt="Torna alla login" title="Torna alla login" @click="$router.push({name:'ApplicationLogin'})">mdi-keyboard-backspace</v-icon>
                                <v-toolbar-title color="secondary" class="font-weight-bold">RESET PASSWORD</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-container>
                                    <v-row v-if="error !== null">
                                        <v-col cols="12" class="py-0">
                                            <v-alert color="warning">{{error}}</v-alert>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12" class="py-0">
                                            <v-stepper
                                                       hide-actions
                                                       prev-text=""
                                                       :next-text="(step.next === 0 ? 'Verifica email' :'Aggiorna')"
                                                       v-model="step.next"
                                            >
                                                <v-stepper-header>
                                                    <v-stepper-item
                                                        v-for="(e,i) in items"
                                                        :title="e"
                                                        :value="i"
                                                        :key="i"
                                                        complete-icon="mdi-check"
                                                        :icon="(i===0 ? 'mdi-email-check' :'mdi-lock-check')"
                                                    ></v-stepper-item>
                                                </v-stepper-header>
                                                <v-stepper-window>

                                                    <v-stepper-window-item value="0" >
                                                        <v-form ref="formStep1" v-model="step.validStep1">
                                                            <v-text-field
                                                                v-model="email"
                                                                :rules="[value => !!value || 'Campo obbligatorio', rules.email]"
                                                                label="Email utente"
                                                                :type="email"
                                                            ></v-text-field>
                                                        </v-form>
                                                    </v-stepper-window-item>

                                                    <v-stepper-window-item value="1" >

                                                        <v-form v-model="step.validStep2" ref="formStep2">
                                                            <v-container>
                                                                <v-row>
                                                                    <v-col cols="12">
                                                                        <v-text-field
                                                                            v-model="form.password"
                                                                            :disabled="getUsersRequest.loading"
                                                                            :rules="[value => !!value || 'Campo obbligatorio']"
                                                                            label="Nuova Password"
                                                                            :type="show.newPassword ? 'text' : 'password'"
                                                                            :append-icon="show.newPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                                                            @click:append="show.newPassword = !show.newPassword"
                                                                        ></v-text-field>
                                                                    </v-col>
                                                                </v-row>
                                                                <v-row>
                                                                    <v-col cols="12">
                                                                        <v-text-field
                                                                            v-model="form.confrimPassword"
                                                                            :disabled="getUsersRequest.loading"
                                                                            :rules="[value => !!value || 'Campo obbligatorio',form.confrimPassword === form.password || 'Le due password non corrispondono']"
                                                                            label="Conferma Password"
                                                                            :type="show.confrimPassword ? 'text' : 'password'"
                                                                            :append-icon="show.confrimPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                                                            @click:append="show.confrimPassword = !show.confrimPassword"
                                                                            :error-messages="error"
                                                                        ></v-text-field>
                                                                    </v-col>
                                                                </v-row>
                                                            </v-container>
                                                        </v-form>


                                                    </v-stepper-window-item>



                                                </v-stepper-window>
                                                <v-stepper-actions @click:next="stepper(step.next)" color="success" :disabled="progress || 'prev'">
                                                    <v-progress-circular indeterminate color="dark" v-if="progress"></v-progress-circular>
                                                </v-stepper-actions>

                                            </v-stepper>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script >

import UsersApi from "../../../mixins/UsersApi.js";
import storeComputed from "../../../mixins/storeComputed.js";

export default {
    name: 'ResetPassword',
    mixins:[UsersApi,storeComputed],
    data: () => ({
        items: ['Email','Password'],
        email: '',
        step: {
            validStep1: false,
            validStep2:false,
            next: 1
        },
        stepNext:{
            next: null,
            ok: false
        },
        rules: {
            email: value => {
                const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                return pattern.test(value) || 'Devi inserire un indirizzo email valido'
            },
        },
        progress: false,
        error: null,
        form : {
            password: '',
            confrimPassword: ''
        },
        getUsersRequest: { loading: false },
        show:{
            password: false,
            confrimPassword: false
        },
        uuid:null,
    }),
    methods: {
        stepper: function (liv){
            this.error    = null
            this.progress = false
            if(liv === 0){
                this.progress = true
                this.$refs.formStep1.validate().then(r => {
                    if(r.valid){
                        this.stepperAjax(this.email).then(r => {
                            this.step.next =(parseInt(liv)+parseInt(1));
                            this.uuid = r.data.data.uuid_request
                        }).catch(e => {
                            let error = e.response.data.errors
                            if(error !== undefined) {
                                this.error = error
                                this.progress = false;
                                this.closeAlert()
                            }
                        })
                    }else
                        this.step.next = liv
                    this.progress = false
                })
            }else{
                this.progress = true
                this.$refs.formStep2.validate().then(r => {
                    if(r.valid){
                        delete this.form.confrimPassword
                        this.changePasswordStepper(this.form,this.uuid).then(r => {
                            this.$router.push({name:'ApplicationLogin',query:{logout: "Password utente aggiornato"}})
                        }).catch(e => {
                            let error = e.response.data.errors
                            if(error !== undefined) {
                                this.error = error
                                this.progress = false;
                                this.closeAlert()
                            }
                        })
                    }else
                        this.step.next = liv
                    this.progress = false
                })
            }

        },
        closeAlert: function () {
            setTimeout(() => {
                this.error = null
                if(this.step.next === 1)
                    this.email = ''
            },5000)
        },

    },
    created() {
        this.step.next = 0;
        this.step.validStep1 = false;
        this.email = '';

    }
}

</script>
