<template>
    <div>
        <edit :is-edit="false"/>
    </div>
</template>

<script>
    import Edit from "./Edit";
    export default {
        name: "AdminCreate",
        components:{
            Edit
        }
    }
</script>

<style scoped>

</style>
