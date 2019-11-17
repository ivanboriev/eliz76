<template>
    <div>
        <v-toolbar dense>
            <v-toolbar-title>Заказчики</v-toolbar-title>
        </v-toolbar>

        <v-layout row wrap>
            <v-flex md3 pa-2>
                <v-card @click="createCustomer" class="mx-auto" style="height:154px; cursor:pointer;"
                        color="blue darken-4">
                    <v-card-text class="d-flex justify-center align-center" style="height: 100%;">
                        <div class="title">Добавить заказчика</div>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex md3 pa-2 v-for="customer in customers" :key="customer.id">
                <v-card class="mx-auto">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on }">
                            <v-card-title v-on="on">{{customer.name.substr(0,20)}}...</v-card-title>
                        </template>
                        <span>{{customer.name}}</span>
                    </v-tooltip>
                    <v-card-text>
                        <template v-if="customer.subjects.length > 0">
                            <v-list dense>
                                <v-subheader>Последние объекты</v-subheader>
                                <v-list-item
                                    link
                                    :to="{name:'dashboard', params:{id:customer.id, sid:subject.id}}"
                                    v-for="subject in customer.subjects"
                                    :key="subject.id"
                                >
                                    <v-list-item-content>
                                        <v-list-item-title v-text="subject.name"></v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </template>
                        <template v-else>Нет объектов</template>
                    </v-card-text>
                    <v-card-actions>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn color="red" v-on="on" @click="openFormDelete(customer)" icon>
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                            <span>Удалить</span>
                        </v-tooltip>

                        <v-spacer></v-spacer>

                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on" color="primary" @click="editCustomer(customer.id)" icon>
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                            </template>
                            <span>Редактировать</span>
                        </v-tooltip>

                        <v-btn color="green" :to="{name:'subjects', params:{id:customer.id}}" text>Объекты</v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-dialog width="400" v-model="formDelete">
                <v-card>
                    <v-card-title>Удалить заказчика?</v-card-title>
                    <v-card-text>Вы действитель хотите удалить заказчика {{customer.name}} ?</v-card-text>
                    <v-card-actions>
                        <v-btn @click="closeFormDelete">Нет</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn color="red" @click="deleteCustomer(customer.id)">Да</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

        </v-layout>
    </div>
</template>

<script>
    export default {
        name: "Customers.vue",
        data: () => ({
            customers: [],
            formDelete: false,
            customer: {
                id: "",
                name: ""
            }
        }),
        methods: {
            closeFormDelete() {
                this.formDelete = false;
            },
            openFormDelete(customer) {
                this.customer = Object.assign({}, customer);
                this.formDelete = true;
            },

            createCustomer() {
                this.$router.push("createCustomer");
            },
            editCustomer(id) {
                this.$router.push({path: "/editCustomer/" + id, params: {id: id}});
            },
            deleteCustomer(id) {
                this.$api
                    .post("/deleteCustomer", {
                        id: id
                    })
                    .then(() => {
                        this.$api.post("/customers").then(res => {
                            this.customers = res.data;
                            this.closeFormDelete();
                        });
                    });
            }
        },
        created() {
            this.$api.post("/customers").then(res => {
                this.customers = res.data;
            });
        }
    };
</script>

<style scoped>
    .v-card__title {
        font-size: 1.3rem;
    }
</style>
