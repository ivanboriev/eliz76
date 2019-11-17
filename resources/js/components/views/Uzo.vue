<template>
    <div>
        <v-toolbar>
            <v-toolbar-title>{{subject}} | {{shield}} Узо</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn class="ma-2" color="red darken-4" @click="deleteRows" :disabled="selected.length  === 0">удалить
            </v-btn>

            <v-btn class="ma-3" v-if="block" @click="changeBlock" tile large color="red" icon>
                <v-icon>mdi-lock</v-icon>
            </v-btn>
            <v-btn class="ma-2" v-else tile @click="changeBlock" large color="teal" icon>
                <v-icon>mdi-lock-open</v-icon>
            </v-btn>
            <v-btn color="blue darken-4" @click="saveUzo">сохранить</v-btn>
        </v-toolbar>
        <v-data-table
            v-model="selected"
            show-select
            item-key="name"
            :headers="headers" :items="uzoData" disable-pagination hide-default-footer>
            <template v-slot:item.name="props">
                <v-edit-dialog :return-value.sync="props.item.name">
                    {{ props.item.name }}
                    <template v-slot:input>
                        <v-text-field v-model="props.item.name" label="Название" single-line></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.automate="props">
                <v-edit-dialog :return-value.sync="props.item.automate">
                    {{ props.item.automate }}
                    <template v-slot:input>
                        <v-text-field v-model="props.item.automate" label="Автомат" single-line></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.nominal="props">
                <v-edit-dialog :return-value.sync="props.item.nominal">
                    {{ props.item.nominal }}
                    <template v-slot:input>
                        <v-text-field v-model="props.item.nominal" label="Тепл.расц" single-line></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.srtr1="props">
                <v-edit-dialog :return-value.sync="props.item.srtr1">
                    {{ props.item.srtr1 }}
                    <template v-slot:input>
                        <v-text-field v-model="props.item.srtr1" label="1 ср.т.р." single-line></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.srdz1="props">
                <v-edit-dialog :return-value.sync="props.item.srdz1">
                    {{ props.item.srdz1 }}
                    <template v-slot:input>
                        <v-text-field v-model="props.item.srdz1" label="1 ср.д.з." single-line></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.srtr2="props">
                <v-edit-dialog :return-value.sync="props.item.srtr2">
                    {{ props.item.srtr2 }}
                    <template v-slot:input>
                        <v-text-field v-model="props.item.srtr2" label="1 ср.т.р." single-line></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.srdz2="props">
                <v-edit-dialog :return-value.sync="props.item.srdz2">
                    {{ props.item.srdz2 }}
                    <template v-slot:input>
                        <v-text-field v-model="props.item.srdz2" label="1 ср.д.з." single-line></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.tepl_rasc="props">
                <v-edit-dialog :return-value.sync="props.item.tepl_rasc">
                    {{ props.item.tepl_rasc }}
                    <template v-slot:input>
                        <v-text-field v-model="props.item.tepl_rasc" label="Тепл. расц." single-line></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.diff="props">
                <v-edit-dialog :return-value.sync="props.item.diff">
                    {{ props.item.diff }}
                    <template v-slot:input>
                        <v-text-field v-model="props.item.diff" label="Дифф" single-line></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.result="props">
                <v-edit-dialog :return-value.sync="props.item.result">
                    {{ props.item.result }}
                    <template v-slot:input>
                        <v-text-field v-model="props.item.result" label="Примечание" single-line></v-text-field>
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
            uzoData: [],
            selected: [],
            block: false,
            headers: [
                {text: "Группа", value: "name"},
                {text: "Тип", value: "automate"},
                {text: "Номинал", value: "nominal"},
                {text: "1ср.т.р.", value: "srtr1"},
                {text: "1ср.д.з.", value: "srdz1"},
                {text: "1ср.т.р.", value: "srtr2"},
                {text: "B1ср.д.з.", value: "srdz2"},
                {text: "Тепл. расц.", value: "tepl_rasc"},
                {text: "Дифф.", value: "diff"},
                {text: "Примечание", value: "result"}
            ],
            loading: false
        }),
        methods: {
            deleteRows() {
                this.uzoData = this.uzoData.filter((el) => {
                    return !this.selected.includes(el);
                });
                this.selected = [];
            },
            getData() {
                this.loading = true;
                this.$api
                    .post("/get_uzo_data", {
                        shid: this.shid
                    })
                    .then(res => {
                        this.uzoData = res.data.uzo_data !== null ? res.data.uzo_data : [];
                        this.block = res.data.uzo_block;
                        this.loading = false;
                    });
            },
            saveUzo() {
                this.loading = true;
                this.$api
                    .post("/save_uzo_data", {
                        shid: this.shid,
                        uzo_data: this.uzoData
                    })
                    .then(() => {
                        this.getData();
                    });
            },
            changeBlock() {
                this.block = !this.block;
                this.loading = true;
                this.$api
                    .post("/change_uzo_block", {
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

<style scoped>
</style>
