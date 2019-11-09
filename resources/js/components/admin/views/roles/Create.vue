<template>
    <div>
        <edit :is-edit="false"/>
    </div>
</template>

<script>
    import Edit from "./Edit";
    export default {
        name: "RoleCreate",
        components: {
            Edit
        }
    }
</script>

<style scoped>

</style>
