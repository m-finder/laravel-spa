<template>
    <section class="text-center sidebar-container" :class="{ 'side-bar-close' : !isCollapse }">
        <div class="sidebar-wrapper">
            <div class="header">
                <b-navbar-brand>
                    <img :src="'/favicon.ico'" class="logo d-inline-block align-bottom" alt="">
                    <span v-if="isCollapse">
                    M-laravel-spa
                </span>
                </b-navbar-brand>
            </div>

            <b-nav vertical class="text-left" type="dark">
                <template v-for="(item, index) in routers">
                    <template v-if="item.children">

                        <!-- 只有一个子菜单-->
                        <b-nav-item v-if="onlyOneShowingChildren(item.children) && !item.hidden && !item.children[0].hidden"
                                :to="item.children[0].path" :id="item.children[0].path">
                            <svg-vue :icon="item.children[0].icon || 'smile'"/>
                            <b-tooltip v-if="!isCollapse" :target="item.children[0].path" placement="right"
                                       boundary="window" triggers="hover">
                                {{ getTitle(item.children[0]) }}
                            </b-tooltip>
                            <span>{{ getTitle(item.children[0]) }}222</span>
                        </b-nav-item>

                        <b-nav-item v-else-if="noShowingChildren(item.children) && !item.hidden"
                                :to="item.path" :id="item.path">
                            <svg-vue :icon="item.icon || 'smile'"/>
                            <b-tooltip v-if="!isCollapse" :target="item.path" placement="right"
                                       boundary="window" triggers="hover">
                                {{ getTitle(item) }}
                            </b-tooltip>
                            <span>{{ getTitle(item) }}111</span>
                        </b-nav-item>

                        <sitebar-item v-else-if="!item.hidden" :name="getTitle(item)" :icon="item.icon" :href="item.path" :id="item.path">
                            <b-nav v-if="isCollapse" vertical class="nav-dropdown-items">
                                <template v-for="(children, i) in item.children">
                                    <b-nav-item v-if="!children.hidden" :to="children.path">
                                        <svg-vue :icon="children.icon || 'smile'"/>
                                        <span>{{ getTitle(children) }}</span>
                                    </b-nav-item>
                                </template>
                            </b-nav>
                            <b-tooltip v-if="!isCollapse" :target="item.path" placement="right"
                                       boundary="window" triggers="hover">
                                <b-nav vertical class="tooltip-nav">
                                    <template v-for="(children, i) in item.children">
                                        <b-nav-item v-if="!children.hidden" :to="children.path">
                                            {{ getTitle(children) }}
                                        </b-nav-item>
                                    </template>
                                </b-nav>
                            </b-tooltip>
                        </sitebar-item>
                    </template>

                    <template v-else>
                        <b-nav-item v-if="!item.hidden" :to="item.path" :id="item.path">
                            <svg-vue :icon="item.icon || 'smile'"/>
                            <b-tooltip v-if="!isCollapse" :target="item.path" placement="right"
                                       boundary="window" triggers="hover">
                                {{ getTitle(item) }}
                            </b-tooltip>
                            <span>{{ getTitle(item) }}</span>
                        </b-nav-item>
                    </template>
                </template>
            </b-nav>
        </div>

    </section>
</template>
<script>
    import {mapGetters} from 'vuex'
    import SitebarItem from './SidebarItem'

    export default {
        name: 'Sidebar',
        components: {
            'sitebar-item': SitebarItem,
        },
        computed: {
            ...mapGetters([
                'sidebar',
                'routers'
            ]),
            isCollapse() {
                return this.sidebar.opened
            }
        },
        methods: {
            onlyOneShowingChildren(children) {
                return children.filter(item => !item.hidden).length === 1
            },
            noShowingChildren(children) {
                return children.filter(item => !item.hidden).length === 0
            },
            getTitle(data) {
                return data.meta && data.meta.title ? data.meta.title : data.name
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
        height: 100%;

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
        .header {
            text-align: center;
            padding: 0;
        }

        .nav-item {
            .nav-link {
                width: 68px;
                padding-left: 25px;
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
        background: rgba(255, 255, 255, .1);
        transition: max-height .3s ease-in-out;

        .nav-link {
            padding-left: 32px;

            span {
                left: 55px;
            }
        }
    }

    .nav-link.active.open {
        svg {
            fill: #1d68a7 !important;
        }
    }

    .active {
        color: #1d68a7 !important;
        background: rgba(255, 255, 255, .1);

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
            border-radius: 5px;
        }
    }
</style>
