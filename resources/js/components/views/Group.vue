<template>
    <div>
        <v-toolbar>
            <v-toolbar-title>{{subject}} | {{shield}} Группы</v-toolbar-title>
            <v-btn class="ml-5" color="primary" @click="formAddGroup = true">
                <v-icon left>mdi-plus</v-icon>
                группы
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn color="green darken-3" class="mr-3" @click="generate">заполнить</v-btn>
        </v-toolbar>
        <draggable v-model="groups" handle=".sortHandle">
            <transition-group>
                <v-toolbar
                    class="mt-5 pt-4 sortableRow d-flex flex-wrap"
                    :key="group.id"
                    v-for="group in groups"
                >
                    <v-layout>
                        <v-flex xs1>
                            <v-btn style="cursor: move" icon class="sortHandle">
                                <v-icon>mdi-cursor-move</v-icon>
                            </v-btn>
                        </v-flex>
                        <v-flex xs1>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-checkbox v-on="on" class="pa-2" v-model="group.numerable" label=""></v-checkbox>
                                </template>
                                <span>Нумеровать</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex>
                            <v-text-field autocomplete="off" v-model="group.name" label="Название группы" single-line
                                          class="pa-2"></v-text-field>
                        </v-flex>
                        <v-flex>

                            <v-text-field autocomplete="off" v-model="group.consumer" label="Потребитель" single-line
                                          class="pa-2"></v-text-field>
                        </v-flex>
                        <v-flex xs5>

                            <v-autocomplete
                                :items="cables"
                                item-text="full_name"
                                return-object
                                v-model="group.cable"
                                class="pa-2"
                                label="Кабель"
                                autocomplete="off"
                                append-icon="mdi-plus"
                                @click:append="formAddCable = true"
                            ></v-autocomplete>
                        </v-flex>
                        <v-flex>
                            <v-combobox
                                autocomplete="off"
                                v-model="group.automate_name"
                                :items="automateNames"
                                class="pa-2"
                                label="Автомат"
                            ></v-combobox>
                        </v-flex>
                        <v-flex xs1>

                            <v-select
                                :items="['C','B','D','None']"
                                v-model="group.automate_category"
                                class="pa-2"
                                label="Характер."
                                autocomplete="off"
                            ></v-select>

                        </v-flex>
                        <v-flex xs1>

                            <v-text-field v-model="group.automate_nominal" class="pa-2" label="Номинал"></v-text-field>
                        </v-flex>
                        <v-flex xs1>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-checkbox v-on="on" class="pa-2" v-model="group.enter" label="В"></v-checkbox>
                                </template>
                                <span>ВВОД</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex xs1>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-checkbox v-on="on" class="pa-2" v-model="group.diff" label="Д"></v-checkbox>
                                </template>
                                <span>ДИФФ</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex xs1>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-checkbox v-on="on" class="pa-2" v-model="group.pred" label="П"></v-checkbox>
                                </template>
                                <span>ПРЕДОХРАНИТЕЛЬ</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex xs1>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-checkbox v-on="on" class="pa-2" v-model="group.uzo" label="У"></v-checkbox>
                                </template>
                                <span>УЗО</span>
                            </v-tooltip>
                        </v-flex>
                       <v-flex xs1>
                           <v-tooltip bottom>
                               <template v-slot:activator="{ on }">
                                   <v-btn icon v-on="on" color="red" @click="openFormDeleteGroup(group)">
                                       <v-icon>mdi-delete</v-icon>
                                   </v-btn>
                               </template>
                               <span>Удалить группу</span>
                           </v-tooltip>
                       </v-flex>
                    </v-layout>
                </v-toolbar>
            </transition-group>
        </draggable>
        <v-dialog v-model="formAddGroup" width="600">
            <v-card>
                <v-card-title>Добавить группы</v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs2>
                                <v-text-field mask="##" v-model="newGroup.g_count" label="Количество"></v-text-field>
                            </v-flex>
                            <v-flex xs5>
                                <v-autocomplete
                                    :items="cables"
                                    return-object
                                    item-text="full_name"
                                    v-model="newGroup.cable"
                                    label="Кабель"
                                    autocomplete="off"
                                ></v-autocomplete>
                            </v-flex>
                            <v-flex xs5>
                                <v-combobox
                                    v-model="newGroup.automate_name"
                                    :items="automateNames"
                                    label="Автомат"
                                ></v-combobox>
                            </v-flex>
                            <v-flex xs2>
                                <v-select
                                    :items="['C','B','D','None']"
                                    v-model="newGroup.automate_category"
                                    label="Характер."
                                    autocomplete="off"
                                ></v-select>
                            </v-flex>
                            <v-flex xs2>
                                <v-text-field autocomplete="off" mask="####" v-model="newGroup.automate_nominal"
                                              label="Номинал"></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="formAddGroup = false">Отмена</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="addGroup">Добавить</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog width="400" v-model="formDeleteGroup">
            <v-card>
                <v-card-title>Удалить группу?</v-card-title>
                <v-card-text>Вы действитель хотите удалить группу {{group.name}} ?</v-card-text>
                <v-card-actions>
                    <v-btn @click="closeFormDeleteGroup">Нет</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="red" @click="deleteGroup(group)">Да</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog width="400" v-model="formAddCable">
            <v-card>
                <v-card-title>Добавить кабель</v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12 md4>
                                <v-text-field v-model="cable.name" label="Название"></v-text-field>
                            </v-flex>
                            <v-flex xs12 md4>
                                <v-text-field mask="#" v-model.number="cable.count"
                                              label="Количество"></v-text-field>
                            </v-flex>
                            <v-flex xs12 md4>
                                <v-text-field v-model.number="cable.weight" label="Толщина"></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="closeFormAddCable">Отмена</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="addCable">Добавить</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-overlay :value="loading">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
    import draggable from "vuedraggable";

    export default {
        name: "Group",
        props: ["id", "sid", "shid", "subject", "shield"],
        components: {
            draggable
        },
        data: () => ({
            formAddCable: false,
            editorNav: "editor",
            loading: true,
            formAddGroup: false,
            formDeleteGroup: false,
            automateNames:[],
            newGroup: {
                name: "",
                consumer: "",
                cable: null,
                automate_name: "",
                automate_category: "C",
                automate_nominal: 10,
                enter: false,
                diff: false,
                pred: false,
                uzo: false,
                g_count: 1
            },
            group: {
                id: "",
                name: ""
            },
            groups: [],
            cables: [],
            cable: {
                name: '',
                count: 2,
                weight: 2.5
            }
        }),
        methods: {
            addCable(){
                this.loading = true;
                this.$api.post('/saveCable',{
                    cable: this.cable
                }).then(res => {
                    this.formAddCable = false;
                    this.cable = {
                        name: '',
                        count: 2,
                        weight: 2.5
                    };
                    this.getCables();
                    this.loading = false;
                });
            },
            closeFormAddCable(){
                this.cable = {
                    name: '',
                    count: 2,
                    weight: 2.5
                };
                this.formAddCable = false;
            },
            closeFormDeleteGroup() {
                this.formDeleteGroup = false;
            },
            openFormDeleteGroup(group) {
                this.group = Object.assign({}, group);
                this.formDeleteGroup = true;
            },
            addGroup() {
                this.loading = true;
                this.$api
                    .post("/addGroups", {
                        groups: this.newGroup,
                        shid: this.shid
                    })
                    .then(() => {
                        this.formAddGroup = false;
                        this.newGroup = {
                            name: "",
                            consumer: "",
                            cable: null,
                            automate_name: "",
                            automate_category: "C",
                            automate_nominal: 10,
                            enter: false,
                            diff: false,
                            pred: false,
                            uzo: false,
                            g_count: 1
                        };
                        this.$api
                            .post("/groups", {
                                shid: this.shid
                            })
                            .then(res => {
                                this.groups = res.data;
                                this.loading = false;
                            });
                    });
            },
            saveGroups() {
                return this.$api
                    .post("/saveGroups", {
                        groups: this.groups
                    });
            },
            getCables(){
                this.$api.post("/cables").then(res => {
                    this.cables = res.data;
                });
            },
            getAutomateNames(){
                this.$api.post("/get_automate_names").then(res => {
                    this.automateNames = res.data;
                });
            },
            deleteGroup(group) {
                this.loading = true;
                this.$api
                    .post("/delete_group", {
                        id: group.id
                    })
                    .then(() => {
                        this.$api
                            .post("/groups", {
                                shid: this.shid
                            })
                            .then(res => {
                                this.groups = res.data;
                                this.loading = false;
                                this.closeFormDeleteGroup();
                            });
                    });
            },

            generate() {
                this.loading = true;
                this.saveGroups().then(() => {
                    this.$api
                        .post("/generate", {
                            sid: this.shid
                        })
                        .then(() => {
                            this.$api
                                .post("/groups", {
                                    shid: this.shid
                                })
                                .then(res => {
                                    this.groups = res.data;
                                    this.loading = false;
                                });
                        });
                });

            }
        },
        mounted() {
            this.loading = true;
            this.$api
                .post("/groups", {
                    shid: this.shid
                })
                .then(res => {
                    this.groups = res.data;
                    this.loading = false;
                });
            this.getCables();
            this.getAutomateNames();
        }
    };
</script>


