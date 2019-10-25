<template>
    <div>
        <p>This is the homepage</p>
        <svg-icon icon-class="qq" />
        <p>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link :to="{ name: 'hello' }">Hello World</router-link>
            <router-link :to="{ name: 'svg' }">svg</router-link>
        </p>
    </div>
</template>
<script>
    export default {

    }
</script>
