<template>
    <div>
        <p>This is the homepage</p>
        <svg-vue icon="like"/>
        <p>
            <router-link to="/base/icons">Icons</router-link> |
            <router-link to="hello">Hello World</router-link>
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
