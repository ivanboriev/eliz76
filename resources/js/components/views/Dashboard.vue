<template>
    <div>
        <v-toolbar>
            <v-toolbar-title>Объект: {{ subject.name }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="formAddCluster = true"
                >Добавить кластер</v-btn
            >
        </v-toolbar>
        <draggable v-model="clusters" handle=".sortHandle" @end="dragReorder">
            <transition-group>
                <v-card
                    class="mt-1"
                    v-for="cluster in clusters"
                    :key="cluster.id"
                >
                    <v-card-title>
                        <v-btn style="cursor: move" icon class="sortHandle">
                            <v-icon>mdi-cursor-move</v-icon>
                        </v-btn>
                        <v-col xs="12" sm="4">
                            <v-text-field
                                :readonly="clustersReadOnly"
                                @click:append="
                                    editAndUpdateClusterName(
                                        cluster.id,
                                        cluster.name
                                    )
                                "
                                :append-icon="
                                    clustersReadOnly
                                        ? 'mdi-pencil'
                                        : 'mdi-content-save'
                                "
                                placeholder="Название кластера"
                                @keyup.enter="
                                    editAndUpdateClusterName(
                                        cluster.id,
                                        cluster.name
                                    )
                                "
                                v-model="cluster.name"
                                autocomplete="off"
                            ></v-text-field>
                        </v-col>

                        <v-spacer></v-spacer>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn
                                    v-on="on"
                                    color="red"
                                    @click="openFormDeleteCluster(cluster)"
                                    icon
                                >
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                            <span>Удалить кластер</span>
                        </v-tooltip>
                    </v-card-title>
                    <v-card-text>
                        <cluster-shields
                            :subjectClusters="clusters"
                            @updated="onUpdated"
                            :cluster="cluster"
                            :id="id"
                            :sid="sid"
                        ></cluster-shields>
                    </v-card-text>
                </v-card>
            </transition-group>
        </draggable>

        <v-dialog width="400" v-model="formAddCluster">
            <v-card>
                <v-card-title>Добавить кластер</v-card-title>
                <v-card-text>
                    <v-text-field
                        autofocus
                        label="Название"
                        v-model="clusterName"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="formAddCluster = false">Отмена</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="addCluster">Добавить</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog width="400" v-model="formDeleteCluster">
            <v-card>
                <v-card-title>Удалить кластер?</v-card-title>
                <v-card-text
                    >Вы действитель хотите удалить кластер
                    {{ clusterObj.name }} ?</v-card-text
                >
                <v-card-actions>
                    <v-btn @click="closeFormDeleteCluster">Нет</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="red" @click="deleteCluster(clusterObj.id)"
                        >Да</v-btn
                    >
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
import ClusterShields from "./ClusterShields";

export default {
    name: "Dashboard",
    components: {
        "cluster-shields": ClusterShields,
        draggable
    },
    computed: {},
    props: ["id", "sid"],
    data: () => ({
        clustersReadOnly: true,
        formAddCluster: false,
        formDeleteCluster: false,
        formAddShields: false,
        selectedCluster: null,
        loading: false,
        clusterObj: {
            id: "",
            name: ""
        },

        clusterName: "",
        subject: {},
        clusters: []
    }),
    methods: {
        editAndUpdateClusterName(id, name) {
            if (this.clustersReadOnly) {
                this.clustersReadOnly = false;
            } else {
                this.$api
                    .post("/updateClusterName", {
                        id: id,
                        name: name
                    })
                    .then(() => {
                        this.clustersReadOnly = true;
                        this.onUpdated();
                    });
            }
        },
        closeFormDeleteCluster() {
            this.formDeleteCluster = false;
            this.clusterObj = {};
        },
        openFormDeleteCluster(cluster) {
            this.clusterObj = Object.assign({}, cluster);
            this.formDeleteCluster = true;
        },
        addCluster() {
            this.clusters.push({ name: this.clusterName, shields: [] });
            this.clusterName = "";
            this.formAddCluster = false;
            this.saveClusters();
        },

        saveClusters() {
            this.loading = true;
            this.$api
                .post("/saveClusters", {
                    clusters: this.clusters,
                    subjectId: this.sid
                })
                .then(() => {
                    this.onUpdated();
                });
        },
        deleteCluster(id) {
            this.$api
                .post("/deleteCluster", {
                    id: id
                })
                .then(() => {
                    this.getClusters();
                    this.formDeleteCluster = false;
                });
        },
        dragReorder() {
            this.saveClusters();
            EventBus.$emit("clusters_updated");
        },

        getClusters() {
            this.loading = true;
            this.$api
                .post("/clusters", {
                    sid: this.sid
                })
                .then(res => {
                    this.clusters = res.data;
                    this.loading = false;
                });
        },

        onUpdated() {
            this.getClusters();
        }
    },
    mounted() {
        this.$api
            .post("/subject", {
                id: this.sid
            })
            .then(res => {
                this.subject = Object.assign({}, res.data.data);
            });
        this.getClusters();
    }
};
</script>
