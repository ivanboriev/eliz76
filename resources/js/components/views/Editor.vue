<template>
    <div>
        <component :is="protocol" :id="id"  :sid="sid" :shid="shid" :subject="subject" :shield="shield"></component>

    </div>
</template>

<script>
    import Group from './Group'
    import Isolate from './Isolate'
    import Phase from './Phase'
    import Uzo from './Uzo'
    import Automate from './Automate'

    export default {
        name: "Editor",
        computed:{
            protocol: {
                get() {
                    return this.$store.getters.protocol;
                },
                set(value) {
                    this.$store.dispatch('set_protocol', value);
                }
            },
        },
        components: {
            'group': Group,
            'isolate': Isolate,
            'phase': Phase,
            'uzo': Uzo,
            'automate': Automate,
        },
        props: ['id', 'sid', 'shid'],
        data: () => ({
            editorNav: 'group',
            subject:'',
            shield:''

        }),
        methods: {
            getEditorData(){
                this.$api.post('get_editor_data',{
                    subject_id: this.sid,
                    shield_id: this.shid
                }).then(res => {
                    this.subject = res.data.subject;
                    this.shield = res.data.shield;
                });;
            }
        },
        created(){
             this.getEditorData();
        },
        mounted() {
            this.$store.dispatch('editor_active', true);


        },
        destroyed() {
            this.$store.dispatch('editor_active', false);
        }

    }
</script>

