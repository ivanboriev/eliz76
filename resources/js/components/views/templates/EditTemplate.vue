<template>
    <v-card>
        <v-card-title>
            Редактировать шаблон
        </v-card-title>
        <v-card-text>
            <v-container grid-list-md>
                <v-layout wrap>
                    <v-flex xs12 md4>
                        <v-text-field
                            v-model="template.name"
                            label="Название"
                            autocomplete="off"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-select
                            label="Тип"
                            v-model="template.type"
                            :items="types"
                            item-text="name"
                            item-value="value"
                            autocomplete="off"
                            show-size
                        ></v-select>
                    </v-flex>
                    <v-flex xs12 md4>
                        <v-file-input
                            v-model="file"
                            show-size
                            label="Файл"
                        ></v-file-input>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-btn @click="cancel">Отмена</v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="updateTemplate">Обновить</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    name: "EditTemplate",
    props: ["id"],
    data: () => ({
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
            { name: "Ведомость дефектов", value: "deffects" }
        ],
        file: null,
        template: {
            id: "",
            name: "",
            type: ""
        }
    }),
    methods: {
        cancel() {
            this.$router.push("/doc-templates");
        },
        getTemplate() {
            this.$api
                .post("/get_template", {
                    id: this.id
                })
                .then(res => {
                    this.template = Object.assign({}, res.data);
                });
        },

        updateTemplate() {
            const config = {
                headers: { "content-type": "multipart/form-data" }
            };
            let formData = new FormData();
            if (this.file) {
                formData.append("doc_file", this.file, this.file.name);
            }

            formData.append("name", this.template.name);
            formData.append("type", this.template.type);
            formData.append("id", this.template.id);
            this.$api
                .post("/update_template", formData, config)
                .then(() => this.$router.push("/doc-templates"));
        }
    },
    mounted() {
        this.getTemplate();
    }
};
</script>

<style scoped></style>
