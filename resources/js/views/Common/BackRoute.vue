<template>
    <v-btn
    icon="mdi-arrow-left-circle"
    color="dark"
    size="small"
    alt="Torna alla login"
    title="Torna alla login"
    @click="$router.push({name:nameRouter})"
    >
    </v-btn>
</template>

<script>
export default {
    name: 'BackRoute',
    props:['nameRouter']
}
</script>
