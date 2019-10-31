<template>
    <section class="text-center sidebar-container" :class="{ 'side-bar-close' : !isCollapse }">
        <div class="sidebar-wrapper">
            <header class="header">
                <b-navbar-brand>
                    <img :src="'/favicon.ico'" class="logo d-inline-block align-bottom" alt="">
                    <span v-if="isCollapse" class="bv-d-md-down-none">
                    M-laravel-spa
                </span>
                </b-navbar-brand>
            </header>

            <b-nav vertical class="text-left" type="dark">
                <template v-for="(item, index) in nav.items">
                    <template v-if="item.children">
                        <router-link tag="li" class="nav-item " :to="item.url" disabled>
                            <a href="#" class="nav-link dropdown-toggle" :id="'tooltip-' + index"
                               @click.stop="toggle($event,this)" disabled>
                                <svg-vue :icon="item.icon || 'smile'"/>
                                <span>{{ item.name }}</span>
                            </a>
                            <b-popover :target="'tooltip-' + index" placement="right" boundary="window"
                                       triggers="hover">
                                <b-nav vertical>
                                    <template v-for="(children, i) in item.children">
                                        <b-nav-item :to="children.url">
                                            <svg-vue :icon="children.icon || 'smile'"/>
                                            <span>{{ children.name }}</span>
                                        </b-nav-item>
                                    </template>
                                </b-nav>
                            </b-popover>

                            <b-nav v-if="isCollapse" vertical class="nav-dropdown-items">
                                <template v-for="(children, i) in item.children">
                                    <b-nav-item :to="children.url">
                                        <svg-vue :icon="children.icon || 'smile'"/>
                                        <span>{{ children.name }}</span>
                                    </b-nav-item>
                                </template>
                            </b-nav>
                        </router-link>
                    </template>
                    <template v-else>
                        <b-nav-item :to="item.url" :id="'tooltip-' + index">
                            <svg-vue :icon="item.icon || 'smile'"/>
                            <b-tooltip v-if="!isCollapse" :target="'tooltip-' + index" placement="right"
                                       boundary="window"
                                       triggers="hover">
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
    import nav from './_nav'
    import SitebarItem from './SidebarItem'
    import storage from '../../../../storage'
    import store from '../../../../store'

    export default {
        name: 'Sidebar',
        components: {
            'sitebar-item': SitebarItem
        },
        data() {
            return {
                nav: nav,
                status: 1,
            }
        },
        computed: {
            ...mapGetters([
                'sidebar'
            ]),
            isCollapse() {
                return this.sidebar.opened
            }
        },
        methods: {
            toggle: function (e) {
                e.preventDefault();
                e.target.parentElement.classList.toggle('open');

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
        transition: all 0.2s;
        width: 200px;
        background: rgba(0, 0, 0, .1);
        height: 100vh;
    }

    .sidebar-wrapper {
        height: 100%;
        width: calc(100% + 30px);
        overflow-x: hidden;
        overflow-y: auto;
    }

    .header {
        text-align: left;
        padding-left: 15px;
    }

    .nav-item span {
        transition: all 0.2s;
        position: absolute;
        left: 40px;
    }

    .side-bar-close, .side-bar-close .header, .side-bar-close .nav {
        width: 68px;
    }

    .side-bar-close {
        .header {
            padding-left: 0;
            text-align: center;
        }

        .nav-item {
            .nav-link {
                text-align: center;
                padding: 0.5rem 0;
            }

            span {
                left: 200px;
            }
        }

        .dropdown-toggle::after {
            display: none;
        }
    }

    .logo {
        width: 30px;
        height: 30px;
    }

    .navbar-brand {
        margin-right: 0;
    }

    .nav {
        width: 200px;
    }

    .nav-link {
        position: relative;
        transition: all 0.2s;

        &:hover {
            background: rgba(255, 255, 255, .1);

            svg {
                fill: #1d68a7 !important;
            }
        }
    }

    .dropdown-toggle::after {
        display: block;
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
        transform: rotate(90deg);
        transition: all 0.2s;
    }

    .nav-dropdown-items {
        max-height: 0;
        width: 100%;
        padding: 0;
        margin: 0;
        overflow: hidden;
        transition: max-height .3s ease-in-out;

        .nav-item {
            width: 100%;
        }
    }

    .open {
        background: rgba(255, 255, 255, .1);
        position: relative;

        .nav-dropdown-items {
            max-height: 1500px;
        }

        .dropdown-toggle::after {
            transform: rotate(0deg);
        }
    }

    svg {
        margin-top: -2px;
        margin-right: 5px;
        fill: #666;
    }

    .active {
        color: #1d68a7 !important;

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
</style>
