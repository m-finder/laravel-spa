<template>
    <div>
        <div class="icon-item-box" v-for="(item,i) of iconsMap" :key="i">
            <div class="icon-item">
                <svg-vue class="nav-status" :icon="item"/>
            </div>
            <div>{{ item }}</div>
        </div>
    </div>
</template>

<script>
    import icons from './requireIcons'
    export default {
        name: "Index",
        data() {
            return {
                iconsMap: icons
            }
        }
    }
</script>

<style scoped>
    .icon-item-box{
        display: inline-block;
        width: 80px;
        height: 30px;
        margin: 25px;
        text-align: center;
    }
</style>