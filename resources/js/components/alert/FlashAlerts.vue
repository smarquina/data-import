<template>
    <div v-if="session.status" class="alert alert-success" role="alert">
        {{session.status}}
    </div>

    <div v-else-if="session.statusError" class="alert alert-danger" role="alert">
        {{session.statusError}}
    </div>

    <div v-else-if="session.statusWarning" class="alert alert-warning" role="alert">
        {{session.statusWarning}}
    </div>

    <div v-else-if="session.statusInfo" class="alert alert-info" role="alert">
        {{session.statusInfo}}
    </div>

</template>

<script>
    export default {
        name: "FlashAlerts",
        data() {
            return {
                session: window.data.session,
            }
        },
    }
</script>

<style scoped>

</style>
