<template>
    <v-card>
        <v-card-title>
            Добавить шаблон
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
                        <v-file-input v-model="file" show-size label="Файл"></v-file-input>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-btn @click="cancel">Отмена</v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="addTemplate">Добавить</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        name: "CreateTemplate",
        data: () => ({
            types: [
                {name: "Титульный лист", value: "title"}
            ],
            file: null,
            template: {
                name: '',
                type: '',
            }
        }),
        methods: {
            cancel() {
                this.$router.push('/doc-templates');
            },

            addTemplate() {
                if (!this.file) {alert('Добавьте файл шаблона!'); return; };
                console.log(this.file instanceof Blob, this.file);
                const config = {headers: {'content-type': 'multipart/form-data'}};
                let formData = new FormData();
                formData.append('doc_file', this.file, this.file.name);
                formData.append('name', this.template.name);
                formData.append('type', this.template.type);
                this.$api.post('/add_template', formData, config).then(() => this.$router.push('/doc-templates'));

            }
        }
    }
</script>

<style scoped>

</style>
