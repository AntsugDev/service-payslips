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
                <PasswordComponent
                    :form="form"
                    :loading="getUsersRequest.loading"
                    :oldPassword="false"
                    ref="PasswordComponent"
                ></PasswordComponent>

            </v-card-text>
            <v-divider dark></v-divider>
            <v-card-actions >
                <v-spacer></v-spacer>
                <v-progress-circular indeterminate color="dark" v-if="getUsersRequest.loading"></v-progress-circular>
                <v-btn :disabled="getUsersRequest.loading" color="info" variant="outlined" @click="$router.push({ name: 'UserIndex' })">
                    chiudi
                </v-btn>
                <v-btn color="success" variant="outlined"  :disabled="getUsersRequest.loading" @click="modifiedPassword">
                    modifica
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>


</template>

<script >


import UsersApi from "../../../mixins/UsersApi.js";
import PasswordComponent from "../../Common/PasswordComponent.vue";

export  default {
    name:'EditPassword',
    components: {PasswordComponent},
    mixins:[UsersApi],
    data: () => ({
        getSelectedUserRequest: { loading: false },
        getUsersRequest: { loading: false },
        dialog: true,
        valid: false,
        form : {
            password: '',
            newPassword: '',
            confirmPassword: ''
        },
        error:null,
    }),
    methods: {
        modifiedPassword: function (){
            if(this.$refs.PasswordComponent.valid){
                    this.getUsersRequest.loading = true
                    delete this.$refs.PasswordComponent.form.confirmPassword
                    return this.changePassword(this.$refs.PasswordComponent.form,this.$route.params.id).then(r => {
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

        }
    }
}
</script>
