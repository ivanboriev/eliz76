import Vue from 'vue';
import Vuex from 'vuex'
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        dark: true,
        protocol: 'group',
        editor_active: false,
    },
    getters: {
        theme: state => state.dark,
        protocol: state => state.protocol,
        editor_active: state => state.editor_active,
    },
    mutations: {
        changeTheme(state) {
            state.dark = !state.dark;
        },
        set_protocol(state, value) {
            state.protocol = value;
        },
        editor_active(state, payload){
            state.editor_active = payload;
        }
    },
    actions: {
        changeTheme(context) {
            context.commit('changeTheme');
        },
        set_protocol(context, value) {
            context.commit('set_protocol', value);
        },
        editor_active(context, payload){
            context.commit('editor_active', payload);
        }
    },
    plugins: [createPersistedState()]
})
