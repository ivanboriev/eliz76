<template>
    <v-card>
        <v-card-title>
            Редактировать кабель
        </v-card-title>
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
            <v-btn @click="cancel">Отмена</v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="updateCable">Обновить</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        name: "EditCable",
        props: ['id'],
        data: () => ({
            cable: {
                name: '',
                count: 2,
                weight: 2.5
            }
        }),
        mounted() {
            this.$api.post('/cable', {
                id: this.id
            }).then(res => {
                this.cable = Object.assign({}, res.data);
            });
        },
        methods: {
            cancel() {
                this.$router.push('/cables');
            },
            updateCable() {
                this.$api.post('/updateCable', {
                    cable: this.cable
                }).then(res => {
                    this.$router.push('/cables')
                });
            }
        }
    }
</script>

