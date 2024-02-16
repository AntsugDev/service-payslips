<template>
    <v-snackbar v-model="$store.getters.show" top :color="$store.getters.color" :timeout="3000" dense>
        {{ $store.getters.show }}
        <template v-slot:action="{ attrs }">
            <v-btn :color="$store.getters.color" fab x-small dark v-bind="attrs"
                   @click="$store.commit('snackbar/update', { show: false })" class="elevation-6">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </template>
    </v-snackbar>

    <router-view></router-view>
</template>

<script>
import storeComputed from "./mixins/storeComputed";

export default {
    mixins: [storeComputed],
    name: "App",

}
</script>

<style lang="scss">
@import "../sass/app.scss";
</style>
