<template>
    <v-card>
        <v-card-title>
            Добавить Объект
        </v-card-title>
        <v-card-text>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 md4>
                        <v-text-field v-model="editedItem.name" autocomplete="off" label="Название"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field v-model="editedItem.address" autocomplete="off" label="Адрес"></v-text-field>
                    </v-flex>
                   <!-- <v-flex xs12 md1>
                        <v-text-field v-model="editedItem.min" mask="####" autocomplete="off" label="Мин"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md1>
                        <v-text-field v-model="editedItem.max"  mask="####" autocomplete="off" label="Макс"></v-text-field>
                    </v-flex>-->
                    <v-flex xs12 md2>
                        <v-text-field v-model="editedItem.temp" autocomplete="off" label="Температура"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md2>
                        <v-text-field v-model="editedItem.atm" autocomplete="off" label="Давление"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md2>
                        <v-text-field v-model="editedItem.humidity"  autocomplete="off" label="Влажность"></v-text-field>
                    </v-flex>
                <!--    <v-flex xs12 md2>
                        <v-text-field v-model="editedItem.contur_temp" autocomplete="off" label="Контур температура"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md2>
                        <v-text-field v-model="editedItem.contur_atm" autocomplete="off" label=" Контур давление"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md2>
                        <v-text-field v-model="editedItem.contur_humidity"  autocomplete="off" label="Контур влажность"></v-text-field>
                    </v-flex>-->

                    <v-flex xs12 md3>
                        <v-checkbox v-model="editedItem.isolate" autocomplete="off" label="Изоляция"></v-checkbox>
                    </v-flex>
                    <v-flex xs12 md3>
                        <v-checkbox v-model="editedItem.phase" autocomplete="off" label="Фаза-ноль"></v-checkbox>
                    </v-flex>
                    <v-flex xs12 md3>
                        <v-checkbox v-model="editedItem.uzo"  autocomplete="off" label="УЗО"></v-checkbox>
                    </v-flex>
                    <v-flex xs12 md3>
                        <v-checkbox v-model="editedItem.automate" autocomplete="off" label="Автоматы"></v-checkbox>
                    </v-flex>

                    <v-flex xs12 md6>
                        <v-text-field v-model="editedItem.engineer1" autocomplete="off" label="Инженер 1"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field v-model="editedItem.engineer2" autocomplete="off" label="Инженер 2"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md12>
                        <v-text-field v-model="editedItem.photo_path" autocomplete="off" label="Путь к фото объекта"></v-text-field>
                    </v-flex>

                </v-layout>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-btn  @click="cancel">Отмена</v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="addSubject">Добавить</v-btn>
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
                address: '',
                temp: "",
              //  contur_temp: "",
                atm: "",
             //   contur_atm: "",
                humidity: "",
              //  contur_humidity: "",
               // min:null,
              //  max:null,
                isolate: false,
                phase: false,
                automate: false,
                uzo: false,
                engineer1: '',
                engineer2: '',
                photo_path: '',
            },
        }),
        methods: {
            cancel() {
                this.$router.push({name: 'subjects', params: {id: this.$route.params.id}});
            },
            addSubject() {
                this.$api.post('/saveSubject', {
                    subject: {
                        name: this.editedItem.name,
                        address: this.editedItem.address,
                        temp: this.editedItem.temp,
                        atm: this.editedItem.atm,
                        humidity: this.editedItem.humidity,
                        isolate: this.editedItem.isolate,
                        phase: this.editedItem.phase,
                        automate: this.editedItem.automate,
                        uzo: this.editedItem.uzo,
                        engineer1: this.editedItem.engineer1,
                        engineer2: this.editedItem.engineer2,
                        photo_path: this.editedItem.photo_path,
                        customer_id: this.$route.params.id,
                    }
                }).then(() => {
                    this.$router.push({name: 'subjects', params: {id: this.$route.params.id}});

                });
            }
        }
    }
</script>

<style scoped>

</style>
