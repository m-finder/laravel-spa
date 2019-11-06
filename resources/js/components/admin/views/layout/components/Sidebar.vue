<template>
    <section class="text-center sidebar-container" :class="{ 'side-bar-close' : !isCollapse }">
        <div class="sidebar-wrapper">
            <header class="header">
                <b-navbar-brand>
                    <img :src="'/favicon.ico'" class="logo d-inline-block align-bottom" alt="">
                    <span v-if="isCollapse">
                    M-laravel-spa
                </span>
                </b-navbar-brand>
            </header>

            <b-nav vertical class="text-left" type="dark">
                <template v-for="(item, index) in nav.items">
                    <template v-if="item.children">
                        <sitebar-item :name="item.name" :icon="item.icon" :href="item.url"
                                      :id="item.url">
                            <b-nav v-if="isCollapse" vertical class="nav-dropdown-items">
                                <template v-for="(children, i) in item.children">
                                    <b-nav-item :to="children.url">
                                        <svg-vue :icon="children.icon || 'smile'"/>
                                        <span>{{ children.name }}</span>
                                    </b-nav-item>
                                </template>
                            </b-nav>
                            <b-tooltip v-if="!isCollapse" :target="item.url" placement="right"
                                       boundary="window" triggers="hover">
                                <b-nav vertical class="tooltip-nav">
                                    <template v-for="(children, i) in item.children">
                                        <b-nav-item :to="children.url">
                                            {{ children.name }}
                                        </b-nav-item>
                                    </template>
                                </b-nav>
                            </b-tooltip>
                        </sitebar-item>

                    </template>
                    <template v-else>
                        <b-nav-item :to="item.url" :id="item.url">
                            <svg-vue :icon="item.icon || 'smile'"/>
                            <b-tooltip v-if="!isCollapse" :target="item.url" placement="right"
                                       boundary="window" triggers="hover">
                                {{item.name}}
                            </b-tooltip>
                            <span>{{ item.name }}</span>
                        </b-nav-item>
                    </template>
                </template>
            </b-nav>
        </div>

    </section>
</template>
<script>
    import {mapGetters} from 'vuex'
    import nav from '../../../router/nav'
    import SitebarItem from './SidebarItem'

    export default {
        name: 'Sidebar',
        components: {
            'sitebar-item': SitebarItem
        },
        data() {
            return {
                nav: nav,
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
        transition: all .2s;
        width: 200px;
        background: rgba(0, 0, 0, .1);
        height: 100vh;

        .sidebar-wrapper {
            height: 100%;
            width: calc(100% + 30px);
            overflow-x: hidden;
            overflow-y: auto;
        }

        .header {
            text-align: left;
            padding-left: 15px;
            margin: 5px 0;

            .navbar-brand {
                margin-right: 0;

                .logo {
                    width: 30px;
                    height: 30px;
                }
            }
        }

        .nav-item {
            width: 200px;
            span {
                transition: left .2s;
                position: absolute;
                left: 40px;
                display: inline-flex;
                max-width: 100%;
                min-width: 180px;
            }
        }

        .nav-link {
            width: 200px;
            position: relative;
            transition: padding-left .2s;
            &:hover {
                color: #1d68a7;
                svg {
                    fill: #1d68a7;
                }
            }
        }
    }

    .side-bar-close, .side-bar-close .header, .side-bar-close .nav-item, .side-bar-close .nav-item .nav-link {
        width: 68px;
    }

    .side-bar-close {
        .header{
            text-align: center;
            padding: 0;
        }
        .nav-item {
            .nav-link {
                width: 68px;
                padding-left:25px;
            }

            span {
                left: 200px;
            }
        }
    }

    .nav-dropdown-items {
        max-height: 0;
        width: 100%;
        padding: 0;
        margin: 0;
        overflow: hidden;
        transition: max-height .3s ease-in-out;
        .nav-link{
            padding-left: 32px;
            span{
                left: 55px;
            }
        }
    }

    .active {
        color: #1d68a7 !important;
        background: rgba(255,255,255,.1);
        svg {
            fill: #1d68a7 !important;
        }

        &:before {
            content: '';
            height: 100%;
            width: 3px;
            position: absolute;
            background: #fff;
            left: 0;
            top: 0;
        }
    }

    .open {
        .nav-dropdown-items {
            max-height: 1500px;
        }
    }

    .tooltip-nav {
        .nav-link {
            color: #ffffff;
            text-align: left;
        }

        .active {
            color: #ffffff !important;

            &:before {
                content: '';
                width: 0;
            }
        }

        .open {
            border-bottom-left-radius: 15px;
            border-top-right-radius: 15px;
        }
    }
</style>
