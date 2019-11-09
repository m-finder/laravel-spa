<template>
    <router-view></router-view>
</template>
<script>
    import storage from '../../storage'
    import {mapGetters} from 'vuex'

    export default {
        name: 'App',
        computed: {
            ...mapGetters([
                'theme',
            ]),
            changeTheme() {
                return this.theme
            }
        },
        watch:{
            changeTheme:function (val) {
                document.body.className = val
            }
        },
        beforeCreate() {
            let theme = storage.get('theme') || 'default'
            if(theme){
                document.body.className = theme
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
