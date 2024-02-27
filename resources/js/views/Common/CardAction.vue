<template>
    <v-card-actions >
        <v-spacer></v-spacer>
        <v-btn  color="info" variant="outlined" :disabled="loading" @click="$router.push({name:route})">
            Chiudi
        </v-btn>
        <v-progress-circular indeterminate color="dark" v-if="loading"></v-progress-circular>
        <v-btn color="success" variant="outlined" :disabled="loading" @click="action">
            {{ btnAction }}
        </v-btn>
    </v-card-actions>
</template>
<script>
export default {
    name: "CardAction",
    props:['loading','route','action','btnAction']
}
</script>
