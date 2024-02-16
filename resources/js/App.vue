<template>
    <router-view></router-view>
</template>

<script>
import storeComputed from "./mixins/storeComputed";
import {mapState} from "vuex";
export default {
    mixins: [storeComputed],
    name: "App",
}
</script>

<style lang="scss">
@import "../sass/app.scss";
</style>
