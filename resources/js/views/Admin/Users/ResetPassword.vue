<template>
    <v-app>
        <v-main>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <SnackBarCommon></SnackBarCommon>
                            <v-toolbar color="primary" dark flat dense>
                                <BackRoute v-if="!firstAccess" name-router="ApplicationLogin"></BackRoute>
                                <v-toolbar-title color="secondary" class="font-weight-bold">RESET PASSWORD</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-container>
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
                                                        <v-row >
                                                            <v-col cols="12">
                                                                <v-chip prepend-icon="mdi-email-check-outline" color="info" variant="elevated">
                                                                    {{ email }}
                                                                </v-chip>
                                                            </v-col>
                                                        </v-row>
                                                        <PasswordComponent
                                                            :form="form"
                                                            :loading="getUsersRequest.loading"
                                                            :oldPassword="true"
                                                            ref="PasswordComponent"
                                                        ></PasswordComponent>
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
import BackRoute from "../../Common/BackRoute.vue";
import SnackBarCommon from "../../Common/SnackBarCommon.vue";
import PasswordComponent from "../../Common/PasswordComponent.vue";

export default {
    name: 'ResetPassword',
    components: {PasswordComponent, SnackBarCommon, BackRoute},
    mixins:[UsersApi,storeComputed],
    data: () => ({
        items: ['Email','Password'],
        email: '',
        firstAccess: false,
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
            confirmPassword: '',
            update:false
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
                if(this.$refs.PasswordComponent.valid){
                    delete this.$refs.PasswordComponent.form.confirmPassword
                    this.changePasswordStepper(this.$refs.PasswordComponent.form,this.uuid).then(r => {
                        this.$router.push({name:'ApplicationLogin',query:{logout: "Password utente aggiornato"}})
                    }).catch(e => {
                        let error = e.response.data.errors
                        if(error !== undefined) {
                            this.progress = false;
                        }
                    })

                }
                else {
                    this.step.next = liv
                    this.progress = false
                }
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
        if(this.$route.query.email !== undefined && this.$route.query.uuid !== undefined){
            this.firstAccess = true;
            this.step.next =1;
            this.uuid  = atob(this.$route.query.uuid)
            this.email = atob(this.$route.query.email)
            this.form.update = true
        }

    }
}

</script>
