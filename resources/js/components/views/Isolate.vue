<template>
    <div>
        <v-toolbar>
            <v-toolbar-title>{{subject}} | {{shield}} Изоляция</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn class="ma-2" color="red darken-4" @click="deleteRows" :disabled="selected.length  === 0">удалить
            </v-btn>
            <v-btn class="ma-3" v-if="block" @click="changeBlock" tile large color="red" icon>
                <v-icon>mdi-lock</v-icon>
            </v-btn>
            <v-btn class="ma-2" v-else tile @click="changeBlock" large color="teal" icon>
                <v-icon>mdi-lock-open</v-icon>
            </v-btn>
            <v-btn color="blue darken-4" @click="saveIsolate">
                сохранить
            </v-btn>


        </v-toolbar>
        <v-data-table
            v-model="selected"
            show-select
            item-key="name"
            :headers="headers"
            :items="isolateData"
            disable-pagination
            hide-default-footer
        >
            <template v-slot:item.name="props">
                <v-edit-dialog
                    :return-value.sync="props.item.name"
                > {{ props.item.name }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.name"
                            label="Название"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.cable="props">
                <v-edit-dialog
                    :return-value.sync="props.item.cable"
                >
                    {{ props.item.cable }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.cable"
                            label="Кабель"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.voltage="props">
                <v-edit-dialog
                    :return-value.sync="props.item.voltage"
                >
                    {{ props.item.voltage }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.voltage"
                            label="Напряжение"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.AB="props">
                <v-edit-dialog
                    :return-value.sync="props.item.AB"
                >
                    {{ props.item.AB }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.AB"
                            label="AB"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.AC="props">
                <v-edit-dialog
                    :return-value.sync="props.item.AC"
                >
                    {{ props.item.AC }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.AC"
                            label="AС"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.BC="props">
                <v-edit-dialog
                    :return-value.sync="props.item.BC"
                >
                    {{ props.item.BC }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.BC"
                            label="BC"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.AN="props">
                <v-edit-dialog
                    :return-value.sync="props.item.AN"
                >
                    {{ props.item.AN }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.AN"
                            label="AN"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.BN="props">
                <v-edit-dialog
                    :return-value.sync="props.item.BN"
                >
                    {{ props.item.BN }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.BN"
                            label="BN"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.CN="props">
                <v-edit-dialog
                    :return-value.sync="props.item.CN"
                >
                    {{ props.item.CN }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.CN"
                            label="CN"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.APE="props">
                <v-edit-dialog
                    :return-value.sync="props.item.APE"
                >
                    {{ props.item.APE }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.APE"
                            label="APE"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.BPE="props">
                <v-edit-dialog
                    :return-value.sync="props.item.BPE"
                >
                    {{ props.item.BPE }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.BPE"
                            label="BPE"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.NPE="props">
                <v-edit-dialog
                    :return-value.sync="props.item.NPE"
                >
                    {{ props.item.NPE }}
                    <template v-slot:input>
                        <v-text-field
                            v-model="props.item.NPE"
                            label="NPE"
                            single-line
                        ></v-text-field>
                    </template>
                </v-edit-dialog>
            </template>
            <template v-slot:item.result="props">
                <v-edit-dialog
                    :return-value.sync="props.item.result"
                >
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
        name: "Isolate",
        props: ['id', 'sid', 'shid', 'subject', 'shield'],
        data: () => ({
            isolateData: [],
            selected: [],
            block: false,
            headers: [
                {text: 'Группа', value: 'name'},
                {text: 'Кабель', value: 'cable'},
                {text: 'Напряжение', value: 'voltage'},
                {text: 'AB', value: 'AB'},
                {text: 'AC', value: 'AC'},
                {text: 'BC', value: 'BC'},
                {text: 'AN', value: 'AN'},
                {text: 'BN', value: 'BN'},
                {text: 'CN', value: 'CN'},
                {text: 'APE', value: 'APE'},
                {text: 'BPE', value: 'BPE'},
                {text: 'CPE', value: 'CPE'},
                {text: 'NPE', value: 'NPE'},
                {text: 'Примечание', value: 'result'},
            ],
            loading: false,
        }),
        methods: {
            deleteRows(){
                this.isolateData = this.isolateData.filter((el) => {
                    return !this.selected.includes(el);
                });
                this.selected = [];
            },
            getData() {
                this.loading = true;
                this.$api.post('/get_isolate_data', {
                    shid: this.shid
                }).then(res => {

                    this.isolateData = res.data.isolate_data !== null ? res.data.isolate_data : [];
                    this.block = res.data.isolate_block;
                    this.loading = false;
                })
            },
            saveIsolate() {
                this.loading = true;
                this.$api.post('/save_isolate_data', {
                    shid: this.shid,
                    isolate_data: this.isolateData
                }).then(() => {
                    this.getData();
                })
            },
            changeBlock() {
                this.block = !this.block;
                this.loading = true;
                this.$api.post('/change_isolate_block', {
                    shid: this.shid,
                    block: this.block
                }).then(() => {
                    this.getData();
                    this.loading = false;
                })
            }
        },
        mounted() {
            this.getData();
        }

    }
</script>

<style scoped>

</style>
