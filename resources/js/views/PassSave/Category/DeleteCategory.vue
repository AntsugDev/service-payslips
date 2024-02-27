<template>
<DialogConfirm title="Cancellazione category"
               text="Premendo conferma si procede con la cancellazione della category"
               back="ListPassSaveCategory"
               btn-text="Conferma"
               :btn-action="deleted"
></DialogConfirm>
</template>
<script>
import DialogConfirm from "../../Common/DialogConfirm.vue";
import Category from "../../../mixins/PassSave/Category.js";

export default {
    name: "DeleteCategory",
    components: {DialogConfirm},
    mixins:[Category],
    methods:{
        deleted:function (){
            this.destroy(this.$route.params.id).then(r => this.$router.push({name:'ListPassSaveCategory'}))
        }
    }
}
</script>


