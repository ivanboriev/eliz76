<template>
    <v-card>
        <v-card-title>
            Добавить заказчика
        </v-card-title>
        <v-card-text>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12>
                        <v-text-field v-model="editedItem.name" label="Название"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field v-model="editedItem.registry_number"
                                      label="Номер реестра"></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field v-model="editedItem.contract_number"
                                      label="Номер контракта"></v-text-field>
                    </v-flex>

                    <!-- <v-flex xs12>
                         <v-text-field v-if="user.role === 2" v-model.number="editedItem.price" label="Стоимость"></v-text-field>
                     </v-flex>
 -->
                    <v-flex xs12 sm6 md4>
                        <v-dialog
                            ref="contract_date_dialog"
                            v-model="contract_date_modal"
                            :return-value.sync="editedItem.contract_date"
                            persistent
                            full-width
                            width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                    v-model="editedItem.contract_date"
                                    label="Дата контракта"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker :first-day-of-week="0" locale="ru"
                                           v-model="editedItem.contract_date" scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="contract_date_modal = false">Отмена
                                </v-btn>
                                <v-btn text color="primary"
                                       @click="$refs.contract_date_dialog.save(editedItem.contract_date)">OK
                                </v-btn>
                            </v-date-picker>
                        </v-dialog>
                    </v-flex>

                    <v-flex xs12 sm6 md4>
                        <v-dialog
                            ref="contract_start_modal_ref"
                            v-model="contract_start_modal"
                            :return-value.sync="editedItem.contract_execution_start"
                            persistent
                            full-width
                            width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                    v-model="editedItem.contract_execution_start"
                                    label="Начало"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker :first-day-of-week="0" locale="ru"
                                           v-model="editedItem.contract_execution_start" scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="contract_start_modal = false">Отмена
                                </v-btn>
                                <v-btn text color="primary"
                                       @click="$refs.contract_start_modal_ref.save(editedItem.contract_execution_start)">
                                    OK
                                </v-btn>
                            </v-date-picker>
                        </v-dialog>
                    </v-flex>
                    <v-flex xs12 sm6 md4>
                        <v-dialog
                            ref="contract_end_modal_ref"
                            v-model="contract_end_modal"
                            :return-value.sync="editedItem.contract_execution_end"
                            persistent
                            full-width
                            width="290px"
                        >
                            <template v-slot:activator="{ on }">
                                <v-text-field
                                    v-model="editedItem.contract_execution_end"
                                    label="Конец"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker :first-day-of-week="0" locale="ru"
                                           v-model="editedItem.contract_execution_end" scrollable>
                                <v-spacer></v-spacer>
                                <v-btn text color="primary" @click="contract_end_modal = false">Отмена
                                </v-btn>
                                <v-btn text color="primary"
                                       @click="$refs.contract_end_modal_ref.save(editedItem.contract_execution_end)">
                                    OK
                                </v-btn>
                            </v-date-picker>
                        </v-dialog>
                    </v-flex>


                </v-layout>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-btn  @click="cancel">Отмена</v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="addCustomer">Добавить</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        name: "CreateCustomer",
        data: () => ({
            contract_date_modal: false,
            contract_start_modal: false,
            contract_end_modal: false,
            editedItem: {
                name: '',
                registry_number: '',
                contract_number: '',
                price: 0,
                contract_date: new Date().toISOString().substr(0, 10),
                contract_execution_start: new Date().toISOString().substr(0, 10),
                contract_execution_end: new Date().toISOString().substr(0, 10),
            },
        }),
        methods: {
            cancel(){
                this.$router.push('/');
            },
            addCustomer() {
                this.$api.post('/saveCustomer', {
                    customer: {
                        name: this.editedItem.name,
                        registry_number: this.editedItem.registry_number,
                        contract_number: this.editedItem.contract_number,
                        price: this.editedItem.price,
                        contract_date: this.editedItem.contract_date,
                        start_date: this.editedItem.contract_execution_start,
                        end_date: this.editedItem.contract_execution_end,
                    }
                }).then(res => {
                    this.$router.push('/');

                });
            }
        }
    }
</script>

<style scoped>

</style>
