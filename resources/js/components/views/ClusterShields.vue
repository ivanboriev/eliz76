<template>
    <div>
        <v-dialog width="600" v-model="formEditShield">
            <v-card>
                <v-card-title>Добавить щит</v-card-title>
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex md6>
                            <v-text-field
                                label="Название"
                                autofocus
                                v-model="shieldData.name"
                            ></v-text-field>
                        </v-flex>
                        <v-flex md6>
                            <v-text-field
                                label="Название групп"
                                v-model="shieldData.group_name"
                            ></v-text-field>
                        </v-flex>
                        <v-flex md6>
                            <v-text-field
                                label="От"
                                mask="#####"
                                v-model="shieldData.min"
                            ></v-text-field>
                        </v-flex>
                        <v-flex md6>
                            <v-text-field
                                label="До"
                                mask="#####"
                                v-model="shieldData.max"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="closeFormEditShield">Отмена</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="updateShield(shieldData)"
                        >Обновить</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog width="400" v-model="formDeleteShield">
            <v-card>
                <v-card-title>Удалить щит?</v-card-title>
                <v-card-text
                    >Вы действитель хотите удалить щит
                    {{ shieldData.name }} ?</v-card-text
                >
                <v-card-actions>
                    <v-btn @click="closeFormDeleteShield">Нет</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="red" @click="deleteShield(shieldData.id)"
                        >Да</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog width="600" v-model="formAddShields">
            <v-card>
                <v-card-title>Добавить щит</v-card-title>
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex md6>
                            <v-text-field
                                label="Название"
                                autofocus
                                v-model="shieldData.name"
                            ></v-text-field>
                        </v-flex>
                        <v-flex md6>
                            <v-text-field
                                label="Название групп"
                                v-model="shieldData.group_name"
                            ></v-text-field>
                        </v-flex>
                        <v-flex md6>
                            <v-text-field
                                label="От"
                                mask="#####"
                                v-model="shieldData.min"
                            ></v-text-field>
                        </v-flex>
                        <v-flex md6>
                            <v-text-field
                                label="До"
                                mask="#####"
                                v-model="shieldData.max"
                            ></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="formAddShields = false">Отмена</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="addShield">Добавить</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-btn color="primary" class="ma-3" @click="openAddShield(cluster.id)"
            >Добавить щит</v-btn
        >

        <draggable
            v-model="shieldsData"
            handle=".sortShieldHandle"
            @end="updateShieldsInCluster"
        >
            <transition-group tag="v-layout" class="row wrap">
                <v-flex
                    md2
                    pa-2
                    v-for="(shield, shi) in shieldsData"
                    :key="shield.id"
                >
                    <v-card class="mx-auto sortableShieldsRow">
                        <v-card-title>
                            <v-btn
                                style="cursor: move"
                                icon
                                class="sortShieldHandle"
                            >
                                <v-icon>mdi-cursor-move</v-icon>
                            </v-btn>
                            {{ shield.name }}
                        </v-card-title>
                        <v-card-text>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn
                                        v-on="on"
                                        color="primary"
                                        @click="copyShield(shield.id)"
                                        icon
                                    >
                                        <v-icon>mdi-content-copy</v-icon>
                                    </v-btn>
                                </template>
                                <span>Копировать</span>
                            </v-tooltip>

                            <v-menu>
                                <template v-slot:activator="{ on }">
                                    <v-btn v-on="on" color="warning" icon>
                                        <v-icon>mdi-database-import</v-icon>
                                    </v-btn>
                                </template>
                                <v-list>
                                    <v-subheader
                                        >Перенести в кластер</v-subheader
                                    >
                                    <v-list-item
                                        v-for="clr in getOtherClusters(
                                            cluster.id
                                        )"
                                        :key="clr.id"
                                        @click="moveShield(shield.id, clr.id)"
                                    >
                                        <v-list-item-title>{{
                                            clr.name
                                        }}</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </v-card-text>
                        <v-card-actions>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn
                                        v-on="on"
                                        color="red"
                                        @click="openFormDeleteShield(shield)"
                                        icon
                                    >
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </template>
                                <span>Удалить</span>
                            </v-tooltip>

                            <v-spacer></v-spacer>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn
                                        v-on="on"
                                        color="primary"
                                        @click="editShield(shield, shi)"
                                        icon
                                    >
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>
                                </template>
                                <span>Редактировать</span>
                            </v-tooltip>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn
                                        v-on="on"
                                        color="green"
                                        :to="{
                                            name: 'editor',
                                            params: {
                                                id: id,
                                                sid: sid,
                                                shid: shield.id
                                            }
                                        }"
                                        icon
                                    >
                                        <v-icon>mdi-table</v-icon>
                                    </v-btn>
                                </template>
                                <span>Открыть</span>
                            </v-tooltip>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </transition-group>
        </draggable>
    </div>
</template>

<script>
import draggable from "vuedraggable";

export default {
    name: "ClusterShields",
    props: {
        cluster: Object,
        id: [Number, String],
        sid: [Number, String],
        subjectClusters: [Array]
    },
    components: {
        draggable
    },

    data: () => ({
        shieldsData: [],
        formEditShield: false,
        formAddShields: false,
        formDeleteShield: false,
        editIndex: -1,
        shieldData: {
            name: "",
            group_name: "Гр.",
            min: "",
            max: ""
        },
        subject_min: "",
        subject_max: ""
    }),
    methods: {
        getMinMax() {
            this.$api
                .post("/min_max", {
                    sid: this.sid
                })
                .then(res => {
                    this.subject_min = res.data.min;
                    this.subject_max = res.data.max;
                    this.setMinMax();
                });
        },
        getOtherClusters(id) {
            return this.subjectClusters.filter(el => el.id !== id);
        },
        moveShield(shield_id, cluster_id) {
            this.$api
                .post("/moveShield", {
                    shield_id: shield_id,
                    cluster_id: cluster_id
                })
                .then(() => {
                    EventBus.$emit("clusters_updated");
                });
        },
        editShield(shield, shi) {
            this.shieldData = Object.assign({}, shield);
            this.formEditShield = true;
            this.editIndex = shi;
        },
        copyShield(id) {
            this.$api.post("/copyShield", { id: id }).then(() => {
                this.getShields();
            });
        },
        updateShield(shield) {
            if (this.editIndex != -1) {
                this.shieldsData[this.editIndex] = shield;
                this.editIndex = -1;
                this.formEditShield = false;
                this.updateShieldsInCluster();
            }
        },
        updateShieldsInCluster() {
            this.$api
                .post("updateShieldsInCluster", {
                    shields: this.shieldsData
                })
                .then(() => {
                    this.getShields();
                });
        },
        openFormDeleteShield(shield) {
            this.shieldData = Object.assign({}, shield);
            this.formDeleteShield = true;
        },
        closeFormEditShield() {
            this.shieldData = {
                name: "",
                group_name: "Гр.",
                min: "",
                max: ""
            };
            this.setMinMax();
            this.formEditShield = false;
        },
        closeFormDeleteShield() {
            this.shieldData = {
                name: "",
                group_name: "Гр.",
                min: "",
                max: ""
            };
            this.setMinMax();
            this.formDeleteShield = false;
        },
        deleteShield(shi) {
            this.$api
                .post("/deleteShield", {
                    id: shi
                })
                .then(() => {
                    this.formDeleteShield = false;
                    this.getShields();
                });
        },
        addShield() {
            this.$api
                .post("add_shield", {
                    cluster_id: this.cluster.id,
                    shield: this.shieldData
                })
                .then(() => {
                    this.shieldData = {
                        name: "",
                        group_name: "Гр.",
                        min: "",
                        max: ""
                    };
                    this.setMinMax();
                    this.selectedCluster = null;
                    this.formAddShields = false;
                    this.getShields();
                });
        },
        openAddShield() {
            this.formAddShields = true;
        },

        getShields() {
            this.$api
                .post("get_shields", {
                    cluster_id: this.cluster.id
                })
                .then(res => {
                    this.shieldsData = res.data;
                });
        },
        setMinMax() {
            this.shieldData.min = this.subject_min;
            this.shieldData.max = this.subject_max;
        }
    },

    mounted() {
        this.getShields();
        this.getMinMax();
        EventBus.$on("clusters_updated", () => {
            this.getShields();
        });
    }
};
</script>

<style scoped></style>
