<template>
    <div>
        <b-nav vertical class="w-25">
            <b-navbar-brand href="#">
                <img src="../../../../../images/avatar.png" class="logo" alt="">
            </b-navbar-brand>
            <b-nav-item active>Active</b-nav-item>
            <b-nav-item>Link</b-nav-item>
            <b-nav-item>Another Link</b-nav-item>
            <b-nav-item disabled>Disabled</b-nav-item>
        </b-nav>
    </div>
</template>
<script>
    export default {
        name: 'Sidebar',
    }
</script>
