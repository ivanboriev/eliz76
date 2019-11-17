<template>
    <div>
        <v-data-table
            :headers="headers"
            :items="cables"
            class="elevation-1"
        >
            <template v-slot:top>
                <v-toolbar>
                    <v-toolbar-title>Кабели</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        @click="createCable"
                    >
                        Добавить кабель
                    </v-btn>
                </v-toolbar>


            </template>
            <template v-slot:item.action="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editCable(item.id)"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    color="red"
                    @click="deleteItem(item)"
                >
                    mdi-delete
                </v-icon>
            </template>

        </v-data-table>


    </div>
</template>

<script>


    export default {
        name: "Cables.vue",
        data: () => ({
            cables: [],
            headers: [
                {
                    text: 'Название',
                    align: 'left',
                    sortable: false,
                    value: 'name',
                },
                {text: 'Полное название', value: 'full_name'},
                {text: 'Кол-во жил', value: 'count'},
                {text: 'Толщина', value: 'weight'},
                {text: 'Напряжение', value: 'voltage'},
                {text: 'Действия', value: 'action', sortable: false},
            ],
        }),
        methods: {
            createCable() {
                this.$router.push('createCable');
            },
            editCable(id) {
                this.$router.push({name: 'editCable', params: {id: id}});
            },

            deleteItem(item) {
                this.$api.post('/deleteCable', {
                    id: item.id
                }).then(() => {
                    this.$api.post('/cables').then(res => {
                        this.cables = res.data;
                    })
                })
            }

        },
        created() {
            this.$api.post('/cables').then(res => {
                this.cables = res.data;
            })
        }
    }
</script>


