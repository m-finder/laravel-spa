<template>
    <section class="app-wrapper">
        <side-bar class="sidebar-container"/>
        <section class="main-container">
            <nav-bar/>
            <app-main/>
        </section>
    </section>
</template>
<script>
    import {Navbar, Sidebar, AppMain} from './components'

    export default {
        name: 'Layout',
        components: {
            'side-bar': Sidebar,
            'nav-bar': Navbar,
            'app-main': AppMain,
        },
    }
</script>
<style lang="scss" scoped>
    .app-wrapper {
        width: 100%;
        height: 100%;
        position: relative;
    }
    .sidebar-container{
        position: absolute;
        left: 0;
        top: 0;
        width:200px;
    }
    .main-container{
        position: absolute;
        right: 0;
        width: calc(100vw - 200px);
        height: 100%;
    }
</style>
