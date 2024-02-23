<template>
    <v-form ref="formCreateCompany" v-model="valid">
        <v-text-field
            :disabled="loading"
            color="primary"
            label="nome"
            name="name"
            v-model="form.name"
            :rules="[value => !!value || 'Campo Obbligatorio']"
            type="text"></v-text-field>


        <v-text-field
            :disabled="loading"
            color="primary"
            label="indirizzo"
            name="address"
            v-model="form.address"
            :rules="[value => !!value || 'Campo Obbligatorio']"
            type="text"></v-text-field>


        <v-text-field
            :disabled="loading"
            color="primary"
            label="telefono"
            name="phone"
            v-model="form.phone"
            :rules="[value => !!value || 'Campo Obbligatorio']"
            type="tel"></v-text-field>


        <v-text-field
            :disabled="loading"
            color="primary"
            label="email"
            name="email"
            v-model="form.email"
            :rules="[value => !!value || 'Campo Obbligatorio', rules.email]"
            type="email"></v-text-field>

        <v-text-field
            :disabled="loading"
            color="primary"
            label="cf/piva"
            name="code_user"
            v-model="form.code_user"
            :rules="[value => !!value || 'Campo Obbligatorio',rules.cf_piva]"
            type="email"
            append-icon="mdi-smart-card"
            @click:append="randomPiva"></v-text-field>


        <v-autocomplete
            label="Città"
            :items="citiesList"
            v-model="form.city"
            dense
            item-title="text"
            item-value="value"
            :rules="[value => !!value || 'Campo obbligatorio']"
            clearable
        ></v-autocomplete>

    </v-form>

</template>
<script>

import storeComputed from "../../../mixins/storeComputed.js";
import Companies from "../../../mixins/Companies.js";
import UsersApi from "../../../mixins/UsersApi.js";

export default {
    name: 'CreateCompany',
    mixins:[storeComputed,Companies,UsersApi],
    data: () => ({
        valid:false,
        loading: false,
        form: {
            name: '',
            address: '',
            phone: '',
            email:'',
            code_user: '',
            city: ''
        },
        citiesList: [],
        rules: {
            email: value => {
                const pattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                return pattern.test(value) || 'Devi inserire un indirizzo email valido'
            },
            cf_piva: value => {
                const pattern = /[A-Za_z0-9]/
                return value.length >=10 && value.length <=17 && pattern.test(value) || "La lunghezza della stringa deve essere compresa tra 11 e 16 e deve contennere lettere e numeri"
            }
        },
    }),
    methods:{
        randomPiva :function (){
            this.generateFiscalCode(2).then(r => {
                this.form.code_user = r.data.data
            })
        },
        cities: function (){
            this.listCities().then(r => {
                let data = r.data.data
                data.map(e => {
                    this.citiesList.push({
                        text: `${e.name}`+`(${e.pr})`,
                        value: e.id
                    })
                })
            })
        }
    },
    created() {
        this.cities()
    }
}
</script>


