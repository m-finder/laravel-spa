<template>
    <section class="app-main" :class="{'app-main-close': !isCollapse}">
        <transition name="fade" mode="out-in">
            <keep-alive :include="cachedViews">
                <router-view />
            </keep-alive>
        </transition>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex'

    export default {
        name: 'AppMain',
        computed: {
            key() {
                return this.$route.path
            },
            cachedViews() {
                return this.$store.state.tagsView.cachedViews
            },
            ...mapGetters([
                'sidebar'
            ]),
            isCollapse() {
                return this.sidebar.opened
            },

        },
    }
</script>
<style scoped>
    .app-main {
        /*84 = navbar + tags-view = 50 +34 */
        min-height: calc(100vh - 84px);
        width: calc(100vw - 200px);
        position: absolute;
        right: 0;
        overflow-x: hidden;
        overflow-y: auto;
        height: 100%;
        display: block;
        padding: 25px;
        transition: width 0.2s;
    }

    .app-main-close {
        width: calc(100vw - 68px);
    }
    /*.content{*/
    /*    padding: 0.75rem 1rem 5rem 1rem;*/
    /*    background: rgba(255,255,255,.1);*/
    /*    !*border-radius: 10px;*!*/
    /*    min-height: 100%;*/
    /*}*/

    .fade-enter-active, .fade-leave-active {
        transition-duration: 0.3s;
        transition-property: opacity;
        transition-timing-function: ease;
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>
