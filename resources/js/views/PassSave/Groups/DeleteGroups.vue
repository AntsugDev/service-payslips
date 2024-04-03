<template>
<DialogConfirm title="Cancellazione groups"
               text="Premendo conferma si procede con la cancellazione del gruppo"
               back="ListPassSaveGroups"
               btn-text="Conferma"
               :btn-action="deleted"
></DialogConfirm>
</template>
<script>
import DialogConfirm from "../../Common/DialogConfirm.vue";
import Groups from "../../../mixins/PassSave/Groups.js";

export default {
    name: "DeleteGroups",
    components: {DialogConfirm},
    mixins:[Groups],
    methods:{
        deleted:function (){
            this.destroy(this.$route.params.id).then(r => this.$router.push({name:'ListPassSaveGroups'}))
        }
    }
}
</script>


