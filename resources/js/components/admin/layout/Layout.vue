<template>
    <section class="app-wrapper">
        <nav-bar/>
        <section class="main-container">
            <side-bar/>
            <app-main/>
        </section>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {Navbar, Sidebar, AppMain} from './components'

    export default {
        name: 'Layout',
        components: {
            'side-bar': Sidebar,
            'nav-bar': Navbar,
            'app-main': AppMain,
        },
        computed: {
            ...mapGetters([
                'sidebar'
            ]),
            isCollapse() {
                return this.sidebar.opened
            }
        },
    }
</script>
<style lang="scss" scoped>
    .app-wrapper {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .main-container {
        position: absolute;
        right: 0;
        height: 100%;
        transition: width 0.2s;
        width: 100vw;
    }
</style>
