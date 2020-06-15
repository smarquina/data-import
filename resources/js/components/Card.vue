<template>
    <div class="container-fluid">
        <div class="card mb-2">
            <div class="card-header">
                <slot name="header"><span :title="title">{{title}}</span></slot>
            </div>
            <div class="card-body">
                <flash-alerts></flash-alerts>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    import FlashAlerts from './alert/FlashAlerts.vue'

    export default {
        name: "Card",
        components: {
            FlashAlerts,
        },
        props: {
            title: {
                type: String,
                default: ''
            },
        },
        data() {
            return {
                errors: window.data.errors,
                session: window.data.session,
            }
        },
    }
</script>

<style scoped>

</style>
