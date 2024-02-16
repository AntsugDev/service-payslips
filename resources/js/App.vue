<template>
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
