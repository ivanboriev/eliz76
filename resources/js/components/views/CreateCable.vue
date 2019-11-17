<template>
    <v-card>
        <v-card-title>
            Добавить кабель
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
            <v-btn color="primary" @click="addCable">Добавить</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        name: "CreateCable",
        data: () => ({
            cable: {
                name: '',
                count: 2,
                weight: 2.5
            }
        }),
        methods: {
            cancel() {
                this.$router.push('/cables');
            },
            addCable() {
                this.$api.post('/saveCable',{
                    cable: this.cable
                }).then(res => {
                    this.$router.push('/cables')
                });
            }
        }
    }
</script>

<style scoped>

</style>
