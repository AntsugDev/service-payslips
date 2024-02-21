<template>
    <v-dialog v-model="dialog" persistent max-width="600">
        <v-card>
            <v-toolbar dark flat color="primary" height="dense">
                <v-toolbar-title class="text-center">
                    <h5 class="text-uppercase font-weight-regular text-wrap" style="letter-spacing: 2px">
                        Modifica password
                    </h5>
                </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                <v-form v-model="valid" ref="formPassword">
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    :disabled="getUsersRequest.loading"
                                    v-model="form.password"
                                    :rules="[value => !!value || 'Campo obbligatorio']"
                                    label="Password Attuale"
                                    :type="show.password ? 'text' : 'password'"
                                    :append-icon="show.password ? 'mdi-eye' : 'mdi-eye-off'"
                                    @click:append="show.password = !show.password"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="form.newPassword"
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
                                    :rules="[value => !!value || 'Campo obbligatorio',form.confrimPassword === form.newPassword || 'Le due password non corrispondono']"
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

            </v-card-text>
            <v-divider dark></v-divider>
            <v-card-actions >
                <v-spacer></v-spacer>
                <v-progress-circular indeterminate color="dark" v-if="getUsersRequest.loading"></v-progress-circular>
                <v-btn :disabled="getUsersRequest.loading" color="primary" @click="$router.push({ name: 'UserIndex' })">
                    chiudi
                </v-btn>
                <v-btn color="primary" :disabled="getUsersRequest.loading" @click="modifiedPassword">
                    modifica
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>


</template>

<script >


import UsersApi from "../../../mixins/UsersApi.js";

export  default {
    name:'EditPassword',
    mixins:[UsersApi],
    data: () => ({
        getSelectedUserRequest: { loading: false },
        getUsersRequest: { loading: false },
        dialog: true,
        valid: false,
        form : {
            password: '',
            newPassword: '',
            confrimPassword: ''
        },
        error:null,
        show:{
            password: false,
            newPassword: false,
            confrimPassword: false
        },
    }),
    methods: {
        modifiedPassword: function (){
            this.$refs.formPassword.validate().then(r => {
                if(r.valid){
                    this.getUsersRequest.loading = true
                    delete this.form.confrimPassword
                    return this.changePassword(this.form,this.$route.params.id).then(r => {
                        this.getUsersRequest.loading = false
                        this.form.confrimPassword = '';
                        this.form.newPassword = '';
                        this.form.password = '';
                        this.show.password =  false;
                        this.show.newPassword =  false;
                        this.show.confrimPassword =  false;
                        this.$router.push({ name: 'UserIndex' })
                    })
                }else{
                    this.form.confrimPassword = '';
                    this.form.newPassword = '';
                    this.form.password = '';
                    this.show.password =  false;
                    this.show.newPassword =  false;
                    this.show.confrimPassword =  false;
                }

            })
        }
    }
}
</script>
