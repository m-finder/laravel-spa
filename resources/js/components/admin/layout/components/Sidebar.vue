<template>
    <section class="text-center sidebar-container" :class="{ 'side-bar-close' : !isCollapse }">
        <b-navbar-brand>
            <img :src="'/favicon.ico'" class="logo d-inline-block align-bottom" alt="">
            <span v-if="isCollapse" class="bv-d-md-down-none">
                M-laravel-spa
            </span>
        </b-navbar-brand>

        <b-nav vertical class="text-left" type="dark">
            <template v-for="(item, index) in nav.items">
                <template v-if="item.children">
                    <li class="nav-item">
                        <a v-b-toggle="index + '-' + item.name" href="#" class="nav-link">1{{ item.name }}</a>
                        <b-collapse :id="index + '-' + item.name">
                            <b-nav vertical>
                                <template v-for="(children, i) in item.children">
                                    <b-nav-item >z{{ children.name }}</b-nav-item>
                                </template>
                            </b-nav>
                        </b-collapse>
                    </li>
                </template>
                <template v-else>
                    <b-nav-item>2{{ item.name }}</b-nav-item>
                </template>
            </template>
        </b-nav>

    </section>
</template>
<script>
    import {mapGetters} from 'vuex'
    import nav from './_nav'

    export default {
        name: 'Sidebar',
        data() {
            return {
                nav: nav
            }
        },
        computed: {
            ...mapGetters([
                'sidebar'
            ]),
            isCollapse() {
                return this.sidebar.opened
            }
        }
    }
</script>
<style lang="scss" scoped>
    .sidebar-container {
        position: absolute;
        left: 0;
        top: 0;
        overflow: hidden;
        transition: width 0.2s;
        width: 200px;
        background: #2f353a;
        color: #ffffff;
    }

    .side-bar-close {
        width: 68px;
    }

    .logo {
        width: 30px;
        height: 30px;
    }
    .navbar-brand{
        margin-right: 0;
    }
    a{
        color: rgba(255,255,255,.7);
        &:hover{
            color: #ffffff;
        }
    }
</style>
