<template>
    <div v-if="!this.loading">
        <card v-for="translationGroup in translationGroups" v-bind:key="translationGroup.locale">
            <template v-slot:header>
                <div class="float-left">
                    {{translationGroup[0].locale_name}}
                </div>
                <div class="float-right">
                    <i v-if="loader" class="fas fa-circle-notch fa-spin fa-2x"></i>
                    <a v-else
                       data-action="save-translations"
                       :data-locale="translationGroup[0].locale"
                       :data-product="translationGroup[0].id"
                       :title="saveTitle"
                       :href="saveRoute"
                       @click.prevent="saveTranslations($event)">
                        <i class="fas fa-save"></i> {{saveTitle}}
                    </a>
                </div>
            </template>


            <form v-for="translation in translationGroup" v-bind:key="translation.id"
                  :data-locale="translationGroup[0].locale">
                <div class="row">
                    <div class="col-6">
                        <form-group attribute="column_name"
                                    :width="8"
                                    :label="columnLabel">
                            <select v-model="translation.column_name"
                                    class="form-control"
                                    required>
                                <option v-for="column in translatableColumns" v-bind:key="column.id"
                                        v-bind:value="column.id">
                                    {{column.text}}
                                </option>
                            </select>
                        </form-group>
                    </div>
                    <div class="col-6">
                        <form-group attribute="value"
                                    :width="8"
                                    :label="valueLabel">
                            <textarea v-model.trim="translation.value"
                                      class="form-control"
                                      rows="3"
                                      required>
                            </textarea>
                        </form-group>
                    </div>
                </div>
            </form>
        </card>
    </div>
</template>

<script>
    export default {
        name: "ProductTranslations",
        props: {
            saveTitle: {
                type: String,
                required: true,
            },
            saveRoute: {
                type: String,
                required: true
            },
            columnLabel: {
                type: String,
                required: true
            },
            valueLabel: {
                type: String,
                required: true
            },
            languageRoute: {
                type: String,
                required: true,
            },
            translationsRoute: {
                type: String,
                required: true,
            },
            columnsRoute: {
                type: String,
                required: true,
            }
        },
        data() {
            return {
                availableLanguages: {},
                translationGroups: {},
                translatableColumns: {},
                loading: true,
                loader: false,
            }
        },
        async created() {
            await this.getLanguages();
            await this.getTranslations();
            await this.getTranslatableColumns();
            this.loading = false;
        },
        mounted() {


        },
        methods: {
            async getLanguages() {
                const response = await fetch(this.languageRoute, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                this.availableLanguages = await response.json();
            },
            async getTranslations() {
                const response = await fetch(this.translationsRoute, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                this.translationGroups = await response.json();
            },
            async getTranslatableColumns() {
                const response = await fetch(this.columnsRoute, {
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                this.translatableColumns = await response.json();
            },
            saveTranslations(event) {
                this.toggleLoader();

                const lang = event.target.getAttribute('data-locale');
                const product = event.target.getAttribute('data-product');
                let langData = [];

                Object.values(this.translationGroups).forEach(translationGroup => {
                    Object.values(translationGroup).filter(translation => {
                        return translation.locale = lang;
                    }).forEach(translation => {
                        langData.push({column: translation.column_name, value: translation.value});
                    })
                });

                fetch(event.target.getAttribute('href'), {
                    headers: {
                        'X-CSRF-TOKEN': window.data.csrfToken,
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    method: "PUT",
                    body: JSON.stringify({locale: lang, product_id: product, data: langData}),
                }).then(res => {
                    res.text().then(function (text) {
                        $('#toast').showToast(text);
                    });
                    this.toggleLoader();
                }).catch(error => {
                    console.error(error);
                    this.toggleLoader();

                });
            },
            toggleLoader() {
                this.loader = !this.loader;
            }
        }
    }
</script>

<style scoped>

</style>
