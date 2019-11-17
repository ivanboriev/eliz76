<template>
    <div>
        <v-toolbar dense v-if="subjects.length > 0">
            <v-toolbar-title>Объекты: {{subjects[0].customer_name}}</v-toolbar-title>
        </v-toolbar>
        <v-layout row wrap>
            <v-flex md3 pa-2>
                <v-card @click="createSubject" class="mx-auto" style="height:154px; cursor:pointer;" color="blue darken-4">
                    <v-card-text class="d-flex justify-center align-center" style="height: 100%;">
                        <div class="title">Добавить объект</div>
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex md3 pa-2 v-for="subject in subjects" :key="subject.id">
                <v-card class="mx-auto">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on }">
                            <v-list-item-title v-on="on" class="headline">{{subject.name.substr(0,20)}}</v-list-item-title>
                                </template>
                                <span>{{subject.name}}</span>
                            </v-tooltip>
                            <v-list-item-subtitle>Создан: {{subject.created}}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-card-text d-flex>

                         <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on" color="primary" @click="copySubject(subject.id)" icon>
                                    <v-icon>mdi-content-copy</v-icon>
                                </v-btn>
                            </template>
                            <span>Копировать</span>
                        </v-tooltip>
                         <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on" color="green" @click="generate(subject.id)" icon>
                                    <v-icon>mdi-folder-zip</v-icon>
                                </v-btn>
                            </template>
                            <span>Создать документы</span>
                        </v-tooltip>
                          <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn
                                    v-on="on"
                                    color="green"
                                    target="_blank"
                                    v-if="subject.documents_generated"
                                    :to="subject.documents_path"
                                    icon
                                >
                                    <v-icon>mdi-progress-download</v-icon>
                                </v-btn>
                            </template>
                            <span>Скачать документы</span>
                        </v-tooltip>


                    </v-card-text>
                    <v-card-actions>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on" color="red" @click="openFormDelete(subject)" icon>
                                    <v-icon>mdi-delete</v-icon>
                                </v-btn>
                            </template>
                            <span>Удалить</span>
                        </v-tooltip>

                        <v-spacer></v-spacer>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on }">
                                <v-btn v-on="on" color="primary" @click="editSubject(subject.id)" icon>
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                            </template>
                            <span>Редактировать</span>
                        </v-tooltip>




                        <v-btn
                            color="primary"
                            :to="{name:'dashboard', params:{id: $route.params.id, sid: subject.id}}"
                            text
                        >Открыть
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-flex>

        </v-layout>
        <v-dialog width="400" v-model="formDelete">
            <v-card>
                <v-card-title>Удалить объект?</v-card-title>
                <v-card-text>Вы действитель хотите удалить объект {{subject.name}} ?</v-card-text>
                <v-card-actions>
                    <v-btn @click="closeFormDelete">Нет</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="red" @click="deleteSubject(subject.id)">Да</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-overlay :value="loading">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
    export default {
        name: "Subjects",
        props: ["id"],
        data: () => ({
            formDelete: false,
            subject: {
                id: "",
                name: ""
            },
            subjects: [],
            loading: false
        }),
        methods: {
            closeFormDelete() {
                this.formDelete = false;
            },
            openFormDelete(subject) {
                this.subject = Object.assign({}, subject);
                this.formDelete = true;
            },
            copySubject(id){
                this.$api.post('/copySubject',{id:id}).then(()=>{
                    this.getSubjects();
                });

            },
            createSubject() {
                this.$router.push({
                    name: "createSubject",
                    params: {id: this.$route.params.id}
                });
            },
            editSubject(id) {
                this.$router.push({
                    name: "editSubject",
                    params: {id: this.$route.params.id, sid: id}
                });
            },
            deleteSubject(id) {
                this.$api.post("/deleteSubject", {id: id}).then(() => {
                    this.$api
                        .post("/subjects", {customerId: this.$route.params.id})
                        .then(res => {
                            this.subjects = res.data;
                            this.formDelete = false;
                        });
                });
            },
            generate(id) {
                this.loading = true;
                this.$api.post("/generate_doc", {id: id}).then(() => {
                    this.getSubjects();
                }).catch(() => this.loading = false);
            },
            getSubjects() {
                this.loading = true;
                this.$api.post("/subjects", {customerId: this.id}).then(res => {
                    this.subjects = res.data;
                    this.loading = false;
                }).catch(() => this.loading = false);
            }
        },
        created() {
            this.getSubjects();
        },
        mounted() {
            this.$store.dispatch("editor_active", false);
        }
    };
</script>

<style scoped>
    .v-application .headline{
        font-size: 1.3rem !important;
    }
</style>
