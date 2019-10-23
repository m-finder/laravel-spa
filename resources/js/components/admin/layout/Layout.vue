<template>
    <div class="app-wrapper">
        here is layout
        <sidebar class="sidebar-container"/>
        <div class="main-container">
            <navbar/>
            <app-main/>
        </div>
    </div>
</template>
<script>
    import { Navbar, Sidebar, AppMain } from './components'
    export default {
        name: 'Layout',
        components: {
            Navbar,
            Sidebar,
            AppMain
        },
    }
</script>
