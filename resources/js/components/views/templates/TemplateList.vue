<template>
    <v-data-table
        :headers="headers"
        :items="templates"
        disable-pagination
        hide-default-footer
        class="elevation-1"
    >
        <template v-slot:top>
            <v-toolbar>
                <v-toolbar-title>Шаблоны</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                    color="blue darken-1"
                    @click="createTemplate"
                >
                    Добавить шаблон
                </v-btn>
            </v-toolbar>

        </template>
        <template v-slot:item.url="{ item }">
            <a :href="item.url">Скачать</a>
        </template>
        <template v-slot:item.action="{ item }">
            <v-icon
                small
                class="mr-2"
                @click="editTemplate(item.id)"
            >
                mdi-pencil
            </v-icon>
            <v-icon
                small
                color="red"
                @click="deleteTemplate(item.id)"
            >
                mdi-delete
            </v-icon>
        </template>

    </v-data-table>
</template>

<script>
    export default {
        name: "TemplateList",
        data: () => ({
            templates: [],
            types: [
                {name: "Титульный лист", value: "title"}
            ],
            headers: [
                {text: 'Название документа', value: 'name'},
                {text: 'Тип документа', value: 'type'},
                {text: 'Файл', value: 'url'},
                {text: 'Действия', value: 'action', sortable: false},
            ],
        }),
        methods: {
            createTemplate() {
                this.$router.push({name: 'createTemplate'});
            },
            editTemplate() {
            },
            deleteTemplate(id) {
                this.$api.post('doc_delete',{id:id})
                    .then(() => this.getTemplates());
            },
            getTemplates() {
                this.$api.post('get_templates')
                    .then(response => this.templates = response.data);
            }
        },
        mounted() {
            this.getTemplates();
        }
    }
</script>

<style scoped>

</style>
