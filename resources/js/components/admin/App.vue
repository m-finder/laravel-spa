<template>
    <router-view></router-view>
</template>
<script>
    import storage from '../../storage'
    import {mapGetters} from 'vuex'

    export default {
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
                console.log(val)
                document.body.className = val
            }
        },
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
