<template>
    <v-dialog v-model="dialog" persistent max-width="600">
        <v-card>
            <v-toolbar dark flat color="primary" height="dense">
                <v-toolbar-title class="text-center">
                    <h5 class="text-uppercase font-weight-regular text-wrap" style="letter-spacing: 2px">
                        {{title}}
                    </h5>
                </v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                {{text}}
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="info"
                    variant="outlined"
                    @click="$router.push({name:back})">
                    Chiudi
                </v-btn>
                <v-btn color="success" variant="outlined"  @click="btnAction">
                    {{btnText}}
                </v-btn>

            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
<script>
import BackRoute from "./BackRoute.vue";

export default {
    name: 'DialogConfirm',
    components: {BackRoute},
    props:['title','text','back','btnText','btnAction'],
    data: () => ({
        dialog:true,
    })
}
</script>

