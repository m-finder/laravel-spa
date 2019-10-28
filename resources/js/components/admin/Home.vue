<template>
    <div>
        <p>This is the homepage</p>
        <svg-vue class="nav-status" :icon="status"/>
        <p>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link :to="{ name: 'hello' }">Hello World</router-link>
        </p>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                status: 'qq'
            }
        }
    }
</script>
