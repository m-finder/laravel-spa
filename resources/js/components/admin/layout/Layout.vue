<template>
    <section class="app-wrapper">
        <side-bar :class="'sidebar-container ' + [isCollapse ? ' side-bar-open' : ' side-bar-close']"/>
        <section :class="'main-container ' + [isCollapse ? 'main-container-close': 'main-container-open']">
            <nav-bar/>
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

    .sidebar-container {
        position: absolute;
        left: 0;
        top: 0;
        overflow: hidden;
        transition: width 0.2s;
    }

    .side-bar-open {
        width: 200px;
    }

    .side-bar-close {
        width: 68px;
    }

    .main-container {
        position: absolute;
        right: 0;
        height: 100%;
        transition: width 0.2s;
    }

    .main-container-close {
        width: calc(100vw - 200px);
    }

    .main-container-open {

        width: calc(100vw - 68px);
    }
</style>
