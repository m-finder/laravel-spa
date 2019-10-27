<template>
    <div>
        <p>This is the homepage</p>
        <p>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link :to="{ name: 'hello' }">Hello World</router-link>
        </p>
    </div>
</template>
<script>
    export default {

    }
</script>
