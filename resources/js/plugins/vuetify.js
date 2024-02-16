import { createVuetify } from "vuetify";
import 'vuetify/dist/vuetify.min.css';
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";
import { it } from 'vuetify/locale'

const customeTheme = {
    dark: false,
    colors: {
        primary: '#248f50',
        secondary: '#fed91f',
        accent: '#82B1FF',
        error: '#FF5252',
        info: '#2196F3',
        success: '#4CAF50',
        warning: '#FFC107',
        coldirettiLightGrey: '#f0f0f0',
        coldirettiGrey: '#E6E6E6',
        coldirettiGreen: '#248F50'
    },
};

const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: "customeTheme",
        themes: {
            customeTheme,
        },
    },
    lang: {
        locales: { it },
        current: 'it',
    }
});

export default vuetify;