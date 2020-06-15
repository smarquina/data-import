<template>

    <div class="form-group row">
        <label v-bind:for="attribute"
               class="col-12 col-form-label text-md-right"
               v-bind:class="[`col-md-${this.widths.label}`]">
            {{ label }}
        </label>
        <div class="col-12" v-bind:class="[`col-md-${this.widths.input}`]">
            <slot></slot>

            <span v-if="attributeError" class="invalid-feedback" role="alert">
                <strong>{{ attributeError }}</strong>
            </span>
        </div>
    </div>

</template>

<script>
    export default {
        name: "FormGroup",
        props: {
            attribute: {
                type: String,
            },
            label: {
                type: String,
            },
            width: {
                type: Number,
                default: 6,
            }
        },
        mounted() {
            this.attributeError = this.errors[this.attribute] ? this.errors[this.attribute] : [''];
            this.attributeError = this.attributeError.join(`, `);
        },
        data() {
            return {
                attributeError: '',
                errors: window.data.errors,
            }
        },
        computed: {
            widths: function () {
                return {
                    input: this.width,
                    label: 12 - this.width,
                }
            }
        },
    }
</script>

<style scoped>

</style>
