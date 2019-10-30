<template>
    <router-view></router-view>
</template>
<script>
    import storage from '../../storage'
    export default {
        beforeCreate() {
            let theme = storage.get('theme')
            if(theme){
                document.body.classList.add(theme)
            }else{
                document.body.classList.add('bg-light-green')
            }
        }
    }
</script>

<style scoped>
    *{
        margin: 0;
        padding: 0;
    }
    html, body{
        width: 100%;
        height: 100%;
    }

</style>