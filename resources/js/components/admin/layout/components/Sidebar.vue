<template>
    <div>
        <b-nav vertical>
            <b-navbar-brand>
                <img src="../../../../../images/avatar.png" class="logo" alt="">
                BootstrapVue
            </b-navbar-brand>
            <b-nav-item to="/home" exact exact-active-class="active">Home</b-nav-item>
            <b-nav-item to="/hello" exact>Hello World</b-nav-item>
            <b-nav-item to="/icons" exact>svg</b-nav-item>
        </b-nav>
    </div>
</template>
<script>
    import { mapGetters } from 'vuex'
    export default {
        name: 'Sidebar',
        data(){
            return{
            }
        },
        computed: {
            ...mapGetters([
                'sidebar'
            ]),
            isCollapse() {
                return this.sidebar.opened
            }
        },
        watch: {
            isCollapse: function (value) {
                console.log(value)
            }
        }
    }
</script>
<style lang="scss" scoped>
    .logo {
        width: 30px;
        height: 30px;
    }
</style>
