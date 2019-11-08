<template>
    <div>
        编辑 {{ id }}
    </div>
</template>

<script>
    export default {
        name: "edit",
        data(){
            return {
                id: this.$route.params.id
            }
        }
    }
</script>

<style scoped>

</style>
