<template>
    <v-form v-model="valid" ref="formPassword">
        <v-container>
            <v-row >
                <v-col cols="12">
                    <v-text-field
                        :disabled="loading"
                        v-model="form.password"
                        :rules="[value => !!value || 'Campo obbligatorio']"
                        label="Password"
                        :type="show.password ? 'text' : 'password'"
                        :append-icon="show.password ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="show.password = !show.password"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12" v-if="!oldPassword">
                    <v-text-field
                        v-model="form.newPassword"
                        :disabled="loading"
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
                        v-model="form.confirmPassword"
                        :disabled="loading"
                        :rules="[value => !!value || 'Campo obbligatorio',confirm]"
                        label="Conferma Password"
                        :type="show.confirmPassword ? 'text' : 'password'"
                        :append-icon="show.confirmPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="show.confirmPassword = !show.confirmPassword"
                        :error-messages="error"
                    ></v-text-field>
                </v-col>
            </v-row>
        </v-container>
    </v-form>
</template>

<script>
export default {
    name:'PasswordComponent',
    props:['form','loading','oldPassword'],
    data:() => ({
        show:{
            password:false,
            newPassword: false,
            confirmPassword: false,
        },
        valid:false,
        error:null,
    }),
    methods:{
        confirm: function (){
            if(!this.oldPassword) {
                if (this.form.hasOwnProperty('confirmPassword') && this.form.hasOwnProperty('newPassword'))
                    return this.form.confirmPassword === this.form.newPassword || "Le due password non corrispondono"
                else
                    return true;
            }else {
                if (this.form.hasOwnProperty('confirmPassword') && this.form.hasOwnProperty('password'))
                    return this.form.confirmPassword  === this.form.password || "Le due password non corrispondono"
                else
                    return true;
            }
        }
    },

}
</script>
