<template>
  <div>
    <v-toolbar>
      <v-toolbar-title>{{subject}} | {{shield}} Фаза-ноль</v-toolbar-title>
      <v-spacer></v-spacer>
        <v-btn class="ma-2" color="red darken-4" @click="deleteRows" :disabled="selected.length  === 0">удалить</v-btn>

        <v-btn class="ma-3s" v-if="block" @click="changeBlock" tile large color="red" icon>
        <v-icon>mdi-lock</v-icon>
      </v-btn>
      <v-btn class="ma-2" v-else tile @click="changeBlock" large color="teal" icon>
        <v-icon>mdi-lock-open</v-icon>
      </v-btn>
      <v-btn color="blue darken-4" @click="savePhase">сохранить</v-btn>
    </v-toolbar>
    <v-data-table
        v-model="selected"
        show-select
        item-key="name"
        :headers="headers" :items="phaseData" disable-pagination hide-default-footer>
      <template v-slot:item.name="props">
        <v-edit-dialog :return-value.sync="props.item.name">
          {{ props.item.name }}
          <template v-slot:input>
            <v-text-field v-model="props.item.name" label="Название" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.automate="props">
        <v-edit-dialog :return-value.sync="props.item.automate">
          {{ props.item.automate }}
          <template v-slot:input>
            <v-text-field v-model="props.item.automate" label="Автомат" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.nominal="props">
        <v-edit-dialog :return-value.sync="props.item.nominal">
          {{ props.item.nominal }}
          <template v-slot:input>
            <v-text-field v-model="props.item.nominal" label="Iном. расц.(А)" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.magn="props">
        <v-edit-dialog :return-value.sync="props.item.magn">
          {{ props.item.magn }}
          <template v-slot:input>
            <v-text-field v-model="props.item.magn" label="Диапазон срабатывания тока" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.pred="props">
        <v-edit-dialog :return-value.sync="props.item.pred">
          {{ props.item.pred }}
          <template v-slot:input>
            <v-text-field v-model="props.item.pred" label="Пред" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.A1="props">
        <v-edit-dialog :return-value.sync="props.item.A1">
          {{ props.item.A1 }}
          <template v-slot:input>
            <v-text-field v-model="props.item.A1" label="A" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.B1="props">
        <v-edit-dialog :return-value.sync="props.item.B1">
          {{ props.item.B1 }}
          <template v-slot:input>
            <v-text-field v-model="props.item.B1" label="B" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.C1="props">
        <v-edit-dialog :return-value.sync="props.item.C1">
          {{ props.item.C1 }}
          <template v-slot:input>
            <v-text-field v-model="props.item.C1" label="C" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.A2="props">
        <v-edit-dialog :return-value.sync="props.item.A2">
          {{ props.item.A2 }}
          <template v-slot:input>
            <v-text-field v-model="props.item.A2" label="A" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.B2="props">
        <v-edit-dialog :return-value.sync="props.item.B2">
          {{ props.item.B2 }}
          <template v-slot:input>
            <v-text-field v-model="props.item.B2" label="B" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.C2="props">
        <v-edit-dialog :return-value.sync="props.item.C2">
          {{ props.item.C2 }}
          <template v-slot:input>
            <v-text-field v-model="props.item.C2" label="C" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.dop="props">
        <v-edit-dialog :return-value.sync="props.item.dop">
          {{ props.item.dop }}
          <template v-slot:input>
            <v-text-field v-model="props.item.dop" label="Доп" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
      <template v-slot:item.fact="props">
        <v-edit-dialog :return-value.sync="props.item.fact">
          {{ props.item.fact }}
          <template v-slot:input>
            <v-text-field v-model="props.item.fact" label="Факт" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>

      <template v-slot:item.result="props">
        <v-edit-dialog :return-value.sync="props.item.result">
          {{ props.item.result }}
          <template v-slot:input>
            <v-text-field v-model="props.item.result" label="Примечание" single-line></v-text-field>
          </template>
        </v-edit-dialog>
      </template>
    </v-data-table>
    <v-overlay :value="loading">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
  </div>
</template>

<script>
export default {
  name: "Phase",
  props: ["id", "sid", "shid", "subject", "shield"],
  data: () => ({
    phaseData: [],
      selected: [],
    block: false,
    headers: [
      { text: "Группа", value: "name" },
      { text: "Тип", value: "automate" },
      { text: "Типы расц.", value: "type" },
      { text: "Iном. расц.(А)", value: "nominal" },
      { text: "Диапазон", value: "magn" },
      { text: "A", value: "A1" },
      { text: "B", value: "B1" },
      { text: "C", value: "C1" },
      { text: "A", value: "A2" },
      { text: "B", value: "B2" },
      { text: "C", value: "C2" },
      { text: "Доп.", value: "dop" },
      { text: "Время.", value: "time" },
      { text: "Примечание", value: "result" }
    ],
    loading: false
  }),
  methods: {
      deleteRows() {
          this.phaseData = this.phaseData.filter((el) => {
              return !this.selected.includes(el);
          });
          this.selected = [];
      },
    getData() {
      this.loading = true;
      this.$api
        .post("/get_phase_data", {
          shid: this.shid
        })
        .then(res => {
          this.phaseData =
            res.data.phase_data !== null ? res.data.phase_data : [];
          this.block = res.data.phase_block;
          this.loading = false;
        });
    },
    savePhase() {
      this.loading = true;
      this.$api
        .post("/save_phase_data", {
          shid: this.shid,
          phase_data: this.phaseData
        })
        .then(() => {
          this.getData();
        });
    },
    changeBlock() {
      this.block = !this.block;
      this.loading = true;
      this.$api
        .post("/change_phase_block", {
          shid: this.shid,
          block: this.block
        })
        .then(() => {
          this.getData();
          this.loading = false;
        });
    }
  },
  mounted() {
    this.getData();
  }
};
</script>

<style scoped>
</style>
