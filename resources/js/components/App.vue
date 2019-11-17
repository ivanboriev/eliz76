<template>
    <v-app>
        <v-navigation-drawer
            v-model="primaryDrawer.model"
            :clipped="primaryDrawer.clipped"
            app
            overflow
        >
            <v-list dense nav>
                <v-list-item to="/" link>
                    <v-list-item-content>
                        <v-list-item-title>Заказчики</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item to="/cables" link>
                    <v-list-item-content>
                        <v-list-item-title>Кабели</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item to="/doc-templates" link>
                    <v-list-item-content>
                        <v-list-item-title>Шаблоны</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item to="/equips" link>
                    <v-list-item-content>
                        <v-list-item-title>Оборудование</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar :clipped-left="primaryDrawer.clipped" app>
            <v-app-bar-nav-icon @click.stop="primaryDrawer.model = !primaryDrawer.model"></v-app-bar-nav-icon>
            <v-toolbar-title>ЭЛИЗ76</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-tooltip bottom>
                <template v-slot:activator="{ on }">
                    <v-btn v-if="!isMain" class="mr-5" @click="back" color="primary" icon dark v-on="on">
                        <v-icon>mdi-backburger</v-icon>
                    </v-btn>
                </template>
                <span>Назад</span>
            </v-tooltip>

            <v-bottom-navigation v-if="editor_active" v-model="protocol" :value="true" max-width="400">
                <v-btn value="group">
                    <span>Группы</span>
                    <v-icon>mdi-file-document-box</v-icon>
                </v-btn>

                <v-btn value="isolate">
                    <span>Изоляция</span>
                    <v-icon>mdi-file-document</v-icon>
                </v-btn>
                <v-btn value="phase">
                    <span>Фаза-ноль</span>
                    <v-icon>mdi-file-document</v-icon>
                </v-btn>
                <v-btn value="uzo">
                    <span>Узо</span>
                    <v-icon>mdi-file-document</v-icon>
                </v-btn>
                <v-btn value="automate">
                    <span>Автоматы</span>
                    <v-icon>mdi-file-document</v-icon>
                </v-btn>
            </v-bottom-navigation>
        </v-app-bar>

        <v-content>
            <v-container fluid>
                <router-view></router-view>
            </v-container>
        </v-content>

        <v-footer app>
            v.{{version}}
            <v-spacer></v-spacer>
            <v-icon @click="changeTheme">$vuetify.icons.color</v-icon>
        </v-footer>
    </v-app>
</template>

<script>
    export default {
        computed: {
            darkEnabled(){
              return this.$store.getters.theme;
            },
            editor_active() {
                return this.$store.getters.editor_active;
            },
            protocol: {
                get() {
                    return this.$store.getters.protocol;
                },
                set(value) {
                    this.$store.dispatch("set_protocol", value);
                }
            }
        },

        data: () => ({

            bottomNav: "editor",
            version: window.version,
            editorOpened: false,
            isMain: false,
            isolate: false,
            primaryDrawer: {
                model: false,
                clipped: true
            }
        }),
        methods: {
            changeTheme() {
                this.$store.dispatch("changeTheme");
            },
            back() {
                this.$router.back();
                this.$store.dispatch('set_protocol', 'group');
            }
        },
        watch: {
            darkEnabled(newValue) {
                this.$vuetify.theme.dark = newValue;
            }
        },
        created() {
            this.$vuetify.theme.dark = this.darkEnabled;
        },
        mounted() {
            this.$router.afterEach((to, from) => {
                if (to.name === "customers") {
                    this.isMain = true;
                } else {
                    this.isMain = false;
                }
            });
        }
    };
</script>
