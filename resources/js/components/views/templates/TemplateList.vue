<template>
    <div>
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
                    <v-btn color="blue darken-1" @click="createTemplate">
                        Добавить шаблон
                    </v-btn>
                </v-toolbar>
            </template>
            <template v-slot:item.url="{ item }">
                <a :href="item.url">Скачать</a>
            </template>
            <template v-slot:item.action="{ item }">
                <v-icon small class="mr-2" @click="editTemplate(item.id)">
                    mdi-pencil
                </v-icon>
                <v-icon small color="red" @click="openFormDelete(item)">
                    mdi-delete
                </v-icon>
            </template>
        </v-data-table>
        <v-dialog width="400" v-model="formDelete">
            <v-card>
                <v-card-title>Удалить шаблон?</v-card-title>
                <v-card-text
                    >Вы действитель хотите удалить шаблон
                    {{ template.name }} ?</v-card-text
                >
                <v-card-actions>
                    <v-btn @click="closeFormDelete">Нет</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="red" @click="deleteTemplate(template.id)"
                        >Да</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    name: "TemplateList",
    data: () => ({
        templates: [],
        template: {},
        formDelete: false,
        types: [
            { name: "Титульный лист", value: "title" },
            { name: "Программа испытаний", value: "program" },
            { name: "Список СИ", value: "ci_list" },
            { name: "Визуальный осмотр", value: "visual" },
            { name: "Непрерывность", value: "nepreriv" },
            { name: "Сопротивление изоляции", value: "isolate" },
            { name: "Фаза нуль", value: "phase" },
            { name: "Контур", value: "contur" },
            { name: "Автоматы", value: "automate" },
            { name: "УЗО", value: "uzo" },
            { name: "Тепловизор", value: "teplovizor" },
            { name: "Ведомось дефектов", value: "deffects" }
        ],
        headers: [
            { text: "Название документа", value: "name" },
            { text: "Тип документа", value: "type" },
            { text: "Файл", value: "url" },
            { text: "Действия", value: "action", sortable: false }
        ]
    }),
    methods: {
        createTemplate() {
            this.$router.push({ name: "createTemplate" });
        },
        openFormDelete(template) {
            this.template = Object.assign({}, template);
            this.formDelete = true;
        },
        closeFormDelete() {
            this.formDelete = false;
        },
        editTemplate(id) {
            this.$router.push({
                name: "editTemplate",
                params: { id: id }
            });
        },
        deleteTemplate(id) {
            this.$api.post("doc_delete", { id: id }).then(() => {
                this.getTemplates();
                this.closeFormDelete();
            });
        },
        getTemplates() {
            this.$api
                .post("get_templates")
                .then(response => (this.templates = response.data));
        }
    },
    mounted() {
        this.getTemplates();
    }
};
</script>

<style scoped></style>
