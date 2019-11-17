<template>
    <v-card>
        <v-card-title>
            Редактировать Объект
        </v-card-title>
        <v-card-text>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 md4>
                        <v-text-field v-model="editedItem.name" label="Название"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md8>
                        <v-text-field v-model="editedItem.address" label="Адрес"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-text-field v-model="editedItem.temp" label="Температура"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-text-field v-model="editedItem.atm" label="Давление"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-text-field v-model="editedItem.humidity" label="Влажность"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md3>
                        <v-checkbox v-model="editedItem.isolate" label="Изоляция"></v-checkbox>
                    </v-flex>
                    <v-flex xs12 md3>
                        <v-checkbox v-model="editedItem.phase" label="Фаза-ноль"></v-checkbox>
                    </v-flex>
                    <v-flex xs12 md3>
                        <v-checkbox v-model="editedItem.uzo" label="УЗО"></v-checkbox>
                    </v-flex>
                    <v-flex xs12 md3>
                        <v-checkbox v-model="editedItem.automate"  label="Автоматы"></v-checkbox>
                    </v-flex>

                    <v-flex xs12 md6>
                        <v-text-field v-model="editedItem.engineer1" label="Инженер 1"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field v-model="editedItem.engineer2" label="Инженер 2"></v-text-field>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-text-field v-model="editedItem.photo_path" label="Путь к фото объекта"></v-text-field>
                    </v-flex>

                </v-layout>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-btn  @click="cancel">Отмена</v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="updateSubject">Обновить</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        name: "CreateCustomer",
        props:['id','sid'],
        data: () => ({
            contract_date_modal: false,
            contract_start_modal: false,
            contract_end_modal: false,
            editedItem: {
                name: '',
                address: '',
                temp: "",
                atm: "",
                humidity: "",
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
                this.$router.push({name: 'subjects', params: {id: this.id}});
            },
            updateSubject() {
                this.$api.post('/updateSubject', {
                    subject: {
                        id: this.editedItem.id,
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
                }).then(res => {
                    this.$router.push({name: 'subjects', params: {id: this.id}});
                });
            }
        },
        mounted() {
            console.log(this.id, this.sid);
            this.$api.post('/subject', {
                id: this.sid
            }).then(res => {
                this.editedItem = Object.assign({}, res.data.data);
            });
        },
    }
</script>

<style scoped>

</style>
