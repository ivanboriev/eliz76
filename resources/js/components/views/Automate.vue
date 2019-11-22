<template>
    <div>
        <v-toolbar>
            <v-toolbar-title
                >{{ subject }} | {{ shield }} Автоматы</v-toolbar-title
            >
            <v-spacer></v-spacer>
            <v-btn
                class="ma-2"
                color="red darken-4"
                @click="deleteRows"
                :disabled="selected.length === 0"
                >удалить
            </v-btn>

            <v-btn
                class="ma-3"
                v-if="block"
                @click="changeBlock"
                tile
                large
                color="red"
                icon
            >
                <v-icon>mdi-lock</v-icon>
            </v-btn>
            <v-btn
                class="ma-2"
                v-else
                tile
                @click="changeBlock"
                large
                color="teal"
                icon
            >
                <v-icon>mdi-lock-open</v-icon>
            </v-btn>
            <v-btn color="blue darken-4" @click="saveAutomate">сохранить</v-btn>
        </v-toolbar>
        <v-data-table
            v-model="selected"
            show-select
            item-key="id"
            :headers="headers"
            :items="automateData"
            disable-pagination
            hide-default-footer
        >
            <template v-slot:item.name="props">
                <v-edit-dialog :return-value.sync="props.item.name">
                    {{ props.item.name }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.name"
                            label="Название"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.automate="props">
                <v-edit-dialog :return-value.sync="props.item.automate">
                    {{ props.item.automate }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.automate"
                            label="Автомат"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.nominal="props">
                <v-edit-dialog :return-value.sync="props.item.nominal">
                    {{ props.item.nominal }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.nominal"
                            label="Номинал"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.tepl_rasc="props">
                <v-edit-dialog :return-value.sync="props.item.tepl_rasc">
                    {{ props.item.tepl_rasc }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.tepl_rasc"
                            label="тепл.расц."
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.magn="props">
                <v-edit-dialog :return-value.sync="props.item.magn">
                    {{ props.item.magn }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.magn"
                            label="магн"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.phase="props">
                <v-edit-dialog :return-value.sync="props.item.phase">
                    {{ props.item.phase }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.phase"
                            label="фаза"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.crat="props">
                <v-edit-dialog :return-value.sync="props.item.crat">
                    {{ props.item.crat }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.crat"
                            label="Кратн"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.tokA="props">
                <v-edit-dialog :return-value.sync="props.item.tokA">
                    {{ props.item.tokA }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.tokA"
                            label="Ток А"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.time="props">
                <v-edit-dialog :return-value.sync="props.item.time">
                    {{ props.item.time }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.time"
                            label="Время"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.sopr="props">
                <v-edit-dialog :return-value.sync="props.item.sopr">
                    {{ props.item.sopr }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.sopr"
                            label="Сопрот"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.result="props">
                <v-edit-dialog :return-value.sync="props.item.result">
                    {{ props.item.result }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.result"
                            label="Примечание"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
        </v-data-table>
        <v-overlay :value="loading">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
export default {
    name: "Uzo",
    props: ["id", "sid", "shid", "subject", "shield"],
    data: () => ({
        automateData: [],
        selected: [],
        block: false,
        headers: [
            { text: "Группа", value: "name" },
            { text: "Тип", value: "automate" },
            { text: "Номинал", value: "nominal" },
            { text: "Тепл. расц.", value: "tepl_rasc" },
            { text: "Манг. расц.", value: "magn" },
            { text: "Фаза", value: "phase" },
            { text: "Крат", value: "crat" },
            { text: "Ток А", value: "tokA" },
            { text: "Время сек", value: "time" },
            { text: "Сопрот", value: "sopr" },
            { text: "Примечание", value: "result" }
        ],
        loading: false
    }),
    methods: {
        deleteRows() {
            this.automateData = this.automateData.filter(el => {
                return !this.selected.includes(el);
            });
            this.selected = [];
        },
        getData() {
            this.loading = true;
            this.$api
                .post("/get_automate_data", {
                    shid: this.shid
                })
                .then(res => {
                    this.automateData =
                        res.data.automate_data !== null
                            ? res.data.automate_data
                            : [];
                    this.block = res.data.automate_block;
                    this.loading = false;
                });
        },
        saveAutomate() {
            this.loading = true;
            this.$api
                .post("/save_automate_data", {
                    shid: this.shid,
                    automate_data: this.automateData
                })
                .then(() => {
                    this.getData();
                });
        },
        changeBlock() {
            this.block = !this.block;
            this.loading = true;
            this.$api
                .post("/change_automate_block", {
                    shid: this.shid,
                    block: this.block
                })
                .then(() => {
                    this.getData();
                    this.loading = false;
                });
        }
    },
    mounted() {
        this.getData();
    }
};
</script>

<style scoped></style>
