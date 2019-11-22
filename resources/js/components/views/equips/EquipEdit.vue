<template>
    <v-card>
        <v-card-title>
            Редактировать оборудование
        </v-card-title>
        <v-card-text>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 md4>
                        <v-text-field
                            v-model="equip.name"
                            label="Название"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-text-field
                            v-model="equip.factory_number"
                            label="Заводской номер"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-dialog
                            ref="modal"
                            v-model="modal"
                            :return-value.sync="equip.check_date"
                            persistent
                            full-width
                            width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                    v-model="equip.check_date"
                                    label="Дата проверки"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                :first-day-of-week="0"
                                locale="ru"
                                v-model="equip.check_date"
                                scrollable
                            >
                                <v-spacer></v-spacer>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="modal = false"
                                    >Отмена
                                </v-btn>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="$refs.modal.save(equip.check_date)"
                                    >OK
                                </v-btn>
                            </v-date-picker>
                        </v-dialog>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-btn @click="cancel">Отмена</v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="updateEquip">Обновить</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    name: "EquipEdit",
    props: ["id"],
    data: () => ({
        modal: false,
        equip: {
            name: "",
            factory_number: "",
            check_date: new Date().toISOString().substr(0, 10)
        }
    }),
    methods: {
        getEquip() {
            this.$api
                .post("/equip", {
                    id: this.id
                })
                .then(res => {
                    this.equip = Object.assign({}, res.data);
                });
        },
        updateEquip() {
            this.$api
                .post("/equip_update", {
                    id: this.equip.id,
                    name: this.equip.name,
                    factory_number: this.equip.factory_number,
                    check_date: this.equip.check_date
                })
                .then(() => {
                    this.$router.push({ name: "equips" });
                });
        },
        cancel() {
            this.$router.push({ name: "equips" });
        }
    },
    mounted() {
        this.getEquip();
    }
};
</script>

<style scoped></style>
