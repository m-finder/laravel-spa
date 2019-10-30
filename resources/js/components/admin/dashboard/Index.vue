<template>
    <div>
        <p>This is the homepage</p>
        <svg-vue icon="like"/>
        <p>
            <router-link :to="{ name: 'dashboard' }">Dashboard</router-link> |
            <router-link :to="{ name: 'hello' }">Hello World</router-link>
        </p>
    </div>
</template>
<script>
    export default {
        data(){
            return {

            }
        }
    }
</script>
