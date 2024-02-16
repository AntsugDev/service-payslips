<template>
    <v-form v-model="valid" ref="form">
        <v-container fluid>
            <v-row>
                <v-col cols="12">
                    <v-text-field v-model="userData.last_name" label="Cognome"
                        :rules="[v => !!v || 'Cognome obbligatorio']"></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field v-model="userData.first_name" label="Nome"
                        :rules="[v => !!v || 'Nome obbligatorio']"></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field v-model="userData.email" label="Email"
                        :rules="[v => !!v || 'Email Obbligatoria', rules.isValidEmail]"></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-autocomplete v-model="userData.role_id" :loading="getUserRolesRequest.loading" :items="roles"
                        item-title="label" item-value="id" :rules="[v => !!v || 'Ruolo Obbligatorio']"
                        label="Ruolo"></v-autocomplete>
                </v-col>
                <v-col cols="12" v-if="showPasswordOption">
                    <v-checkbox v-model="enabledPassword" label="Modifica password"></v-checkbox>
                </v-col>
                <v-col cols="12" v-if="enabledPassword">
                    <v-text-field v-model="userData.password" label="Password"
                        :rules="[v => !!v || 'Password obbligatorio', rules.isValidPassword]" clearable dense
                        persistent-hint :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="showPassword ? 'text' : 'password'"
                        @click:append="showPassword = !showPassword"></v-text-field>
                </v-col>
                <v-col cols="12" v-if="enabledPassword">
                    <v-text-field v-model="userData.password_confirmation" label="Conferma Password"
                        :rules="[v => !!v || 'Password di conferma obbligatoria', passwordConfirmation]" clearable dense
                        :append-icon="showConfirmationPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        :type="showConfirmationPassword ? 'text' : 'password'"
                        @click:append="showConfirmationPassword = !showConfirmationPassword"></v-text-field>
                </v-col>
            </v-row>
        </v-container>
    </v-form>
</template>

<script>
import ResponseErrorHandler from "../../../../mixins/ResponseErrorHandler";
import storeComputed from "../../../../mixins/storeComputed";
import usersApi from "../../../../mixins/UsersApi";

export default {
    name: "UserForm",
    props: ['selectedUser'],
    mixins: [ResponseErrorHandler, storeComputed, usersApi],
    data: () => ({
        valid: false,
        getUserRolesRequest: { loading: false },
        roles: [],
        showPasswordOption: false,
        showPassword: false,
        showConfirmationPassword: false,
        enabledPassword: true,
        userData: {
            last_name: "",
            first_name: "",
            email: "",
            role_id: null,
            password: "",
            password_confirmation: "",
        },
        rules: {
            isValidEmail: (value) => {
                if (value !== null && value.length > 0) {
                    let regex = RegExp(/^(([^<>()\\[\]\\.,;:\s@\\"]+(\.[^<>()\\[\]\\.,;:\s@\\"]+)*)|(\\".+\\"))@(([^<>()[\]\\.,;:\s@\\"]+\.)+[^<>()[\]\\.,;:\s@\\"]{2,})$/);
                    return regex.test(value) || 'Inserire un\'email valida'
                } else {
                    return true
                }
            },
            isValidPassword: (value) => {
                if (value.length > 0) {
                    if (value.length >= 8) {
                        let regex = /^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!*$#@%]).*$/;
                        return regex.test(value) || 'La password deve contenere almeno una lettera maiuscola, una minuscola, un numero e un carattere speciale tra (!*$#@%)'
                    } else {
                        return 'La password deve essere lunga almeno 8 caratteri'
                    }
                } else {
                    return true
                }
            },
        }
    }),
    computed: {
        passwordConfirmation: function () {
            let valid;
            (this.userData.password === this.userData.password_confirmation) ? valid = true : valid = "Password non coincidono";
            return valid;
        }
    },
    methods: {
        setUserRoles: function () {
            this.getUserRolesRequest.loading = true;
            this.getUserRoles().then(response => {
                this.roles = response.data.data.map(role => {
                    return role.role;
                })
            }).catch(error => {
                this.handleResponseError(error);
            }).finally(() => {
                this.getUserRolesRequest.loading = false;
            })
        },
    },
    created() {
        if (this.selectedUser !== undefined) {
            Object.assign(this.userData, {
                last_name: this.selectedUser.last_name,
                first_name: this.selectedUser.first_name,
                email: this.selectedUser.email,
                role_id: this.selectedUser.role_id
            });
            this.showPasswordOption = true;
            this.enabledPassword = false;
        }
        this.setUserRoles();
    }
}
</script>
