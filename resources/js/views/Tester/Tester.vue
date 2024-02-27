<template>

    <template v-for="item in items">


        <v-list density="compact"
                :opened="opened"
                @update:opened="newOpened => opened = newOpened.slice(-1)"
                v-if="item.children.length > 0"
        >
            <v-list-group v-model="item.active" >
                <template v-slot:activator="{ props }">
                    <v-list-item
                        :key="item.text"
                        v-bind="props"
                        :title="item.text"
                    ></v-list-item>
                </template>

                <v-list-item
                    v-for="subMenu in item.children"
                    :key="subMenu"
                    :title="subMenu.text"
                ></v-list-item>
            </v-list-group>
        </v-list>

        <v-list density="compact" v-else>
            <v-list-item
                :title="item.text"
            ></v-list-item>
        </v-list>

    </template>


</template>
<script>
export default {
    name: "Tester",
    data() {
        return {
            opened:[],
            items: [
                {text:'No sottomenù',active:false,children:[]},
                {
                    text: 'SottoMenù',
                    children: [
                        { text: 'SottoMenù1' },
                        { text: 'SottoMenù2' }
                    ],
                    active: false
                },
            ]
        };
    }
}
</script>
