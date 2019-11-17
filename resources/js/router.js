import Vue from 'vue'
import VueRouter from 'vue-router'
import Customers from "./components/views/Customers";
import CreateCustomer from "./components/views/CreateCustomer";
import EditCustomer from "./components/views/EditCustomer";
import Subjects from "./components/views/Subjects";
import CreateSubject from "./components/views/CreateSubject";
import EditSubject from "./components/views/EditSubject";
import Dashboard from "./components/views/Dashboard";
import Editor from "./components/views/Editor";
import Cables from "./components/views/Cables";
import CreateCable from "./components/views/CreateCable";
import EditCable from "./components/views/EditCable";
import TemplateList from "./components/views/templates/TemplateList";
import CreateTemplate from "./components/views/templates/CreateTemplate";
import EquipList from "./components/views/equips/EquipList";
import EquipAdd from "./components/views/equips/EquipAdd";

Vue.use(VueRouter);

export default new VueRouter({
    mode:'history',
    routes: [
        {
            path: '/',
            name: 'customers',
            component: Customers
        },
        {
            path: '/cables',
            name: 'cables',
            component: Cables
        },
        {
            path: '/createCable',
            name: 'createCable',
            component: CreateCable
        },
        {
            path: '/editCable/:id',
            name: 'editCable',
            component: EditCable,
            props: true
        },
        {
            path: '/createCustomer',
            name: 'createCustomer',
            component: CreateCustomer
        },
        {
            path: '/editCustomer/:id',
            name: 'editCustomer',
            component: EditCustomer,
            props: true
        },
        {
            path: '/customer/:id/subjects',
            name: 'subjects',
            component: Subjects,
            props: true
        },
        {
            path: '/customer/:id/createSubject',
            name: 'createSubject',
            component: CreateSubject
        },
        {
            path: '/customer/:id/subject/:sid/edit',
            name: 'editSubject',
            component: EditSubject,
            props: true
        },
        {
            path: '/customer/:id/subject/:sid/dashboard',
            name: 'dashboard',
            component: Dashboard,
            props: true
        },
        {
            path: '/customer/:id/subject/:sid/shield/:shid/editor',
            name: 'editor',
            component: Editor,
            props: true
        },
        {
            path: '/doc-templates',
            name: 'templates',
            component: TemplateList
        },
        {
            path: '/createTemplate',
            name: 'createTemplate',
            component: CreateTemplate
        },
        {
            path: '/equips',
            name: 'equips',
            component: EquipList
        },
        {
            path: '/equips_add',
            name: 'equips-add',
            component: EquipAdd
        },
    ]
})
