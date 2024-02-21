<template>
    <v-btn
        fab
        small
        icon="mdi-account-edit"
        :alt="'Dettaglio utente '+$store.getters['user/getEmailUser']"
        :title="'Dettaglio utente '+$store.getters['user/getEmailUser']"
        @click="$router.push({name:'UserIndex'})"
    >
    </v-btn>

    <v-btn
        icon="mdi-logout"
        color="dark"
        size="small"
        alt="Torna alla login"
        title="Torna alla login"
        @click="$router.push({ name: 'ApplicationLogin',query:{logout: 'Logout effettuato'} })"
    >
    </v-btn>
</template>
<script>

import storeComputed from "../../mixins/storeComputed.js";

export default {
    name:'BtnLogout',
    props:['logoutMsg'],
    mixins:[storeComputed],
}

</script>
