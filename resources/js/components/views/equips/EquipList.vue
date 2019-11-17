<template>
    <v-data-table
        :headers="headers"
        :items="equips"
        disable-pagination
        hide-default-footer
        class="elevation-1"
    >
        <template v-slot:top>
            <v-toolbar>
                <v-toolbar-title>Оборудование</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                    color="blue darken-1"
                    @click="createEquip"
                >
                    Добавить оборудование
                </v-btn>
            </v-toolbar>

        </template>

        <template v-slot:item.action="{ item }">
            <v-icon
                small
                class="mr-2"
                @click="editEquip(item.id)"
            >
                mdi-pencil
            </v-icon>
            <v-icon
                small
                color="red"
                @click="deleteEquip(item.id)"
            >
                mdi-delete
            </v-icon>
        </template>
    </v-data-table>
</template>

<script>
    export default {
        name: "EquipList",
        data: () => ({
            equips: [],
            headers: [
                {text: 'Название', value: 'name'},
                {text: 'Заводской номер', value: 'factory_number'},
                {text: 'Дата проверки', value: 'check_date'},
                {text: 'Действия', value: 'action', sortable: false},
            ],
        }),
        methods: {
            createEquip() {
                this.$router.push({name: 'equips-add'});
            },
            editEquip() {
            },
            deleteEquip(id) {
                this.$api.post('equip_delete',{id:id})
                    .then(() => this.getTemplates());
            },
            getEquips() {
                this.$api.post('equips')
                    .then(response => this.equips = response.data);
            }
        },
        mounted() {
            this.getEquips();
        }
    }
</script>

<style scoped>

</style>
