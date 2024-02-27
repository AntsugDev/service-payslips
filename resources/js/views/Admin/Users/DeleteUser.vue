<template>

    <DialogConfirm
    title="Cancellazione utenza"
    text="Premendo confermando si procedere con la cancellazione dell'utenza."
    btn-text="Conferma"
    :back="$route.query.back"
    :btn-action="deleteUser"
    ></DialogConfirm>

</template>
<script>
import DialogConfirm from "../../Common/DialogConfirm.vue";
import UsersApi from "../../../mixins/UsersApi.js";

export default {
    name: 'DeleteUser',
    components: {DialogConfirm},
    mixins:[UsersApi],
    methods:{
        deleteUser: function (){
            this.delUser(this.$route.params.id).then(r => {
                this.$router.push({name: 'ListUser'})
            })
        }
    }
}
</script>
