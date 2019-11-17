<template>
    <section class="app-wrapper">
        <side-bar/>
        <section class="main-container"  :class="{'main-container-open': !isCollapse}">
            <nav-bar/>
            <tags/>
            <app-main/>
        </section>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {Navbar, Sidebar, AppMain, Tags} from './components'

    export default {
        name: 'Layout',
        components: {
            'side-bar': Sidebar,
            'nav-bar': Navbar,
            'app-main': AppMain,
            'tags': Tags
        },
        computed: {
            ...mapGetters([
                'sidebar'
            ]),
            isCollapse() {
                return this.sidebar.opened
            },
        },

    }
</script>
<style lang="scss" scoped>
    .main-container-open{
        width: calc(100vw - 68px)!important;
    }
</style>
