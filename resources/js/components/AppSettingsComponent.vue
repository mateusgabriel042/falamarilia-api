<template>
    <div class="card bg-secondary shadow">
        <div class="card-header">
            <div class="row align-items-center">
                <h3 class="mb-0">Configurações</h3>
            </div>
            <div class="pull-right">

            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" v-for="(setting, index) in settings" :key="index">
                    <a class="nav-link"
                        :class="{'active': index === 0}"
                        :id="`${setting.ref}-tab`"
                        data-toggle="tab"
                        :href="`#${setting.ref}`"
                        role="tab"
                        :aria-controls="setting.ref"
                        aria-selected="true">{{ setting.label }}</a>
                </li>
            </ul>
            <div class="tab-content" id="tabSettings">
                <!-- show active -->
                <div class="tab-pane fade my-4" :class="{'show active': index === 0}" v-for="(setting, index) in settings" :key="index" :id="setting.ref" role="tabpanel" :aria-labelledby="`${setting.ref}-tab`">
                    <div class="row">
                        <div class="col-md-4" v-for="(config,index) in setting.payload" :key="index">
                            <div class="form-group">
                                <label :for="config.key" class="form-custom-control-label">{{ config.label }}</label>
                                <input class="form-control"
                                    v-bind="inputProps(config)"
                                    :name="config.key"
                                    :id="config.key"
                                    v-model="config.value">
                                <small>* {{ config.description }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success" @click.prevent="save(setting)">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AppSettingsComponent",

        props: {
          source: String
        },

        computed: {
            settings() {
                return JSON.parse(this.source)
            },

            inputProps() {
                return config => {
                    let { value } = config;

                    // if(parseInt(value)) return {type: 'number'}

                    // return {type: 'text'}
                    return {}
                }
            }
        },

        methods: {
            async save(config) {
                const { id, payload } = config;
                await axios.put(`/api/system/configurations/${id}`, { payload })
                    .then(() => alert('Configuração salva com sucesso.'))
            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
