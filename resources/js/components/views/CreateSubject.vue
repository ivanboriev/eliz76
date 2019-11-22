<template>
  <v-card>
    <v-card-title>Добавить Объект</v-card-title>
    <v-card-text>
      <v-container grid-list-md>
        <v-layout wrap>
          <v-flex xs12 md4>
            <v-text-field v-model="editedItem.name" autocomplete="off" label="Название"></v-text-field>
          </v-flex>
          <v-flex xs12 md8>
            <v-text-field v-model="editedItem.address" autocomplete="off" label="Адрес"></v-text-field>
          </v-flex>
        </v-layout>
        <v-layout wrap>
          <v-flex xs12 md1>
            <v-text-field v-model="editedItem.min"  v-mask="min_max_mask" autocomplete="off" label="Мин"></v-text-field>
          </v-flex>
          <v-flex xs12 md1>
            <v-text-field v-model="editedItem.max" v-mask="min_max_mask" autocomplete="off" label="Макс"></v-text-field>
          </v-flex>
          <v-flex xs12 md2>
            <v-text-field v-model="editedItem.temp" autocomplete="off" label="Температура"></v-text-field>
          </v-flex>
          <v-flex xs12 md1>
            <v-text-field v-model="editedItem.atm" autocomplete="off" label="Давление"></v-text-field>
          </v-flex>
          <v-flex xs12 md1>
            <v-text-field v-model="editedItem.humidity" autocomplete="off" label="Влажность"></v-text-field>
          </v-flex>
          <v-flex xs12 md2>
            <v-text-field
              v-model="editedItem.contur_temp"
              autocomplete="off"
              label="Контур температура"
            ></v-text-field>
          </v-flex>
          <v-flex xs12 md2>
            <v-text-field
              v-model="editedItem.contur_atm"
              autocomplete="off"
              label=" Контур давление"
            ></v-text-field>
          </v-flex>
          <v-flex xs12 md2>
            <v-text-field
              v-model="editedItem.contur_humidity"
              autocomplete="off"
              label="Контур влажность"
            ></v-text-field>
          </v-flex>
        </v-layout>
        <v-layout wrap>
          <v-flex xs12 md2>
            <v-checkbox v-model="editedItem.isolate" autocomplete="off" label="Изоляция"></v-checkbox>
          </v-flex>
          <v-flex xs12 md2>
            <v-checkbox v-model="editedItem.phase" autocomplete="off" label="Фаза-ноль"></v-checkbox>
          </v-flex>
          <v-flex xs12 md2>
            <v-checkbox v-model="editedItem.uzo" autocomplete="off" label="УЗО"></v-checkbox>
          </v-flex>
          <v-flex xs12 md2>
            <v-checkbox v-model="editedItem.automate" autocomplete="off" label="Автоматы"></v-checkbox>
          </v-flex>
          <v-flex xs12 md2>
            <v-checkbox disabled autocomplete="off" label="Чертежи"></v-checkbox>
          </v-flex>
        </v-layout>
        <v-layout wrap>
          <v-flex xs12 md2>
            <v-select
              v-model="editedItem.isolate_equip"
              :items="equips"
              label="Оборудование изоляции"
              :item-text="(item)=>item.name"
              :item-value="(item) => item.id"
              multiple
            >
              <template v-slot:selection="{ item, index }">
                <v-chip v-if="index === 0">
                  <span>{{ item.name }}</span>
                </v-chip>
                <span
                  v-if="index === 1"
                  class="grey--text caption"
                >(+{{ editedItem.isolate_equip.length - 1 }} других)</span>
              </template>
            </v-select>
          </v-flex>
          <v-flex xs12 md2>
            <v-select
              v-model="editedItem.phase_equip"
              :items="equips"
              label="Оборудование фаза ноль"
              :item-text="(item)=>item.name"
              :item-value="(item) => item.id"
              multiple
            >
              <template v-slot:selection="{ item, index }">
                <v-chip v-if="index === 0">
                  <span>{{ item.name }}</span>
                </v-chip>
                <span
                  v-if="index === 1"
                  class="grey--text caption"
                >(+{{ editedItem.phase_equip.length - 1 }} других)</span>
              </template>
            </v-select>
          </v-flex>
          <v-flex xs12 md2>
            <v-select
              v-model="editedItem.uzo_equip"
              :items="equips"
              label="Оборудование узо"
              :item-text="(item)=>item.name"
              :item-value="(item) => item.id"
              multiple
            >
              <template v-slot:selection="{ item, index }">
                <v-chip v-if="index === 0">
                  <span>{{ item.name }}</span>
                </v-chip>
                <span
                  v-if="index === 1"
                  class="grey--text caption"
                >(+{{ editedItem.uzo_equip.length - 1 }} других)</span>
              </template>
            </v-select>
          </v-flex>
          <v-flex xs12 md2>
            <v-select
              v-model="editedItem.automate_equip"
              :items="equips"
              label="Оборудование автоматы"
              :item-text="(item)=>item.name"
              :item-value="(item) => item.id"
              multiple
            >
              <template v-slot:selection="{ item, index }">
                <v-chip v-if="index === 0">
                  <span>{{ item.name }}</span>
                </v-chip>
                <span
                  v-if="index === 1"
                  class="grey--text caption"
                >(+{{ editedItem.automate_equip.length - 1 }} других)</span>
              </template>
            </v-select>
          </v-flex>
          <v-flex xs12 md2>
            <v-select
              v-model="editedItem.contur_equip"
              :items="equips"
              label="Оборудование контур"
              :item-text="(item)=>item.name"
              :item-value="(item) => item.id"
              multiple
            >
              <template v-slot:selection="{ item, index }">
                <v-chip v-if="index === 0">
                  <span>{{ item.name }}</span>
                </v-chip>
                <span
                  v-if="index === 1"
                  class="grey--text caption"
                >(+{{ editedItem.contur_equip.length - 1 }} других)</span>
              </template>
            </v-select>
          </v-flex>
          <v-flex xs12 md2>
            <v-select
              v-model="editedItem.teplovizor_equip"
              :items="equips"
              label="Оборудование тепловизор"
              :item-text="(item)=>item.name"
              :item-value="(item) => item.id"
              multiple
            >
              <template v-slot:selection="{ item, index }">
                <v-chip v-if="index === 0">
                  <span>{{ item.name }}</span>
                </v-chip>
                <span
                  v-if="index === 1"
                  class="grey--text caption"
                >(+{{ editedItem.teplovizor_equip.length - 1 }} других)</span>
              </template>
            </v-select>
          </v-flex>
        </v-layout>
        <v-layout wrap>
          <v-flex xs12 md6>
            <v-text-field v-model="editedItem.engineer1" autocomplete="off" label="Инженер 1"></v-text-field>
          </v-flex>
          <v-flex xs12 md6>
            <v-text-field v-model="editedItem.engineer2" autocomplete="off" label="Инженер 2"></v-text-field>
          </v-flex>
          <v-flex xs12 md12>
            <v-text-field
              v-model="editedItem.photo_path"
              autocomplete="off"
              label="Путь к фото объекта"
            ></v-text-field>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card-text>
    <v-card-actions>
      <v-btn @click="cancel">Отмена</v-btn>
      <v-spacer></v-spacer>
      <v-btn color="primary" @click="addSubject">Добавить</v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
import { mask } from 'vue-the-mask'
export default {
  name: "CreateCustomer",
  directives:{mask},
  data: () => ({
    min_max_mask:'#####',
    contract_date_modal: false,
    contract_start_modal: false,
    contract_end_modal: false,
    equips: [],
    editedItem: {
      name: "",
      address: "",
      temp: "",
      contur_temp: "",
      atm: "",
      contur_atm: "",
      humidity: "",
      contur_humidity: "",
      isolate_equip: [],
      phase_equip: [],
      uzo_equip: [],
      automate_equip: [],
      contur_equip: [],
      teplovizor_equip: [],
      min: null,
      max: null,
      isolate: false,
      phase: false,
      automate: false,
      uzo: false,
      engineer1: "",
      engineer2: "",
      photo_path: ""
    }
  }),
  mounted() {
    this.getEquips();
  },
  methods: {
    cancel() {
      this.$router.push({
        name: "subjects",
        params: { id: this.$route.params.id }
      });
    },
    getEquips() {
      this.$api.post("equips").then(response => (this.equips = response.data));
    },
    addSubject() {
      this.$api
        .post("/saveSubject", {
          subject: {
            name: this.editedItem.name,
            address: this.editedItem.address,
            min: this.editedItem.min,
            max: this.editedItem.max,
            temp: this.editedItem.temp,
            atm: this.editedItem.atm,
            humidity: this.editedItem.humidity,
            contur_temp: this.editedItem.contur_temp,
            contur_atm: this.editedItem.contur_atm,
            contur_humidity: this.editedItem.contur_humidity,
            isolate: this.editedItem.isolate,
            phase: this.editedItem.phase,
            automate: this.editedItem.automate,
            uzo: this.editedItem.uzo,
            engineer1: this.editedItem.engineer1,
            engineer2: this.editedItem.engineer2,
            photo_path: this.editedItem.photo_path,
            customer_id: this.$route.params.id,
            isolate_equip:this.editedItem.isolate_equip ,
            phase_equip: this.editedItem.phase_equip,
            uzo_equip: this.editedItem.uzo_equip,
            automate_equip: this.editedItem.automate_equip,
            contur_equip: this.editedItem.contur_equip,
            teplovizor_equip:this.editedItem.teplovizor_equip
          }
        })
        .then(() => {
          this.$router.push({
            name: "subjects",
            params: { id: this.$route.params.id }
          });
        });
    }
  }
};
</script>

<style scoped>
</style>
