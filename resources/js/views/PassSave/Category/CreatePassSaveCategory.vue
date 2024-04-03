<template>
    <v-main>
        <v-dialog v-model="dialog" persistent max-width="600">
            <v-card>
                <v-toolbar dark flat color="primary" height="dense">
                    <v-toolbar-title class="text-center">
                        <h5 class="text-uppercase font-weight-regular text-wrap" style="letter-spacing: 2px">
                            CREA CATEGORY
                        </h5>
                    </v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" class="py-0">
                                <v-form ref="formCreateCategory" :v-model="valid"  >
                                    <v-text-field
                                        :disabled="loading"
                                        color="primary"
                                        label="Nome"
                                        name="name"
                                        v-model="form.name"
                                        :rules="[value => !!value || 'Campo Obbligatorio']"
                                        type="text"></v-text-field>
                                </v-form>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <CardAction :loading="loading" route="ListPassSaveCategory" btn-action="Crea" :action="saveCategory"></CardAction>
            </v-card>
        </v-dialog>
    </v-main>

</template>
<script>

import CardAction from "../../Common/CardAction.vue";
import Category from "../../../mixins/PassSave/Category.js";

export default {
    name: "CreatePassSaveCategory",
    components: {CardAction},
    mixins:[Category],
    data: () => ({
        dialog: true,
        valid:false,
        loading:false,
        form:{
            name: null
        }
    }),
    methods:{
        saveCategory: function (){
            this.$refs.formCreateCategory.validate().then(r => {
                if(r.valid){
                    this.create(this.form).then(r => {
                        this.$router.push({name:'ListPassSaveCategory'})
                    })
                }
            })

        }
    }
}
</script>
