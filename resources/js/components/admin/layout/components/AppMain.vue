<template>
    <section class="app-main" :class="{'app-main-close': !isCollapse}">
        <bread-crumb :list="list"/>
        <transition name="fade-transform" mode="out-in">
            <keep-alive :include="cachedViews">
                <router-view :key="key" class="content"/>
            </keep-alive>
        </transition>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex'
    import BreadCrumb from '../../breadcrumb/Index'
    export default {
        name: 'AppMain',
        components:{
            'bread-crumb':BreadCrumb
        },
        computed: {
            key() {
                return this.$route.fullPath
            },
            cachedViews() {
                // return this.$store.state.tagsView.cachedViews
            },
            ...mapGetters([
                'sidebar'
            ]),
            isCollapse() {
                return this.sidebar.opened
            },
            name() {
                return this.$route.name
            },
            list() {
                return this.$route.matched.filter((route) => route.name || route.meta.label)
            }
        },
        methods: {
            getName (item) {
                return item.meta && item.meta.label ? item.meta.label : item.name || null
            },
            isLast (index) {
                return index === this.list.length - 1
            }
        }
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
    .content{
        padding: 0.75rem 1rem;
    }
</style>
