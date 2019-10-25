<template>
    <section class="app-main">
        <keep-alive :include="cachedViews">
            <router-view :key="key"/>
        </keep-alive>
    </section>
</template>
<script>
    export default {
        name: 'AppMain',
        computed: {
            key() {
                return this.$route.fullPath
            },
            cachedViews() {
                // return this.$store.state.tagsView.cachedViews
            }
        }
    }
</script>
<style scoped>
    .app-main {
        /*84 = navbar + tags-view = 50 +34 */
        min-height: calc(100vh - 84px);
        width: 100%;
        position: relative;
        overflow: hidden;
    }
</style>