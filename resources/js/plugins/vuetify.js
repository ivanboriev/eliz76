import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import '@mdi/font/css/materialdesignicons.css'

Vue.use(Vuetify);
import store from '../store'

export default new Vuetify({

    icons: {
        iconfont: 'mdi', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4'
        values: {
            plus: 'mdi-plus',
            color: 'mdi-invert-colors',
        },
    },
})
