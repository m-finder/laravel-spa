<template>
    <div class="sidebar-container" :class="{ 'side-bar-close' : !isCollapse }">
        <ul class="nav">
            <template v-for="(item, index) in nav.items">
                <template v-if="item.title">
                    <!--                        <SidebarNavTitle :key="index" :name="item.name" :classes="item.class" :wrapper="item.wrapper"/>-->
                    <li class="nav-title">
                        <template v-if="item.wrapper && item.wrapper.element">
                            <component v-bind:is="item.wrapper.element" v-bind="item.wrapper.attributes">
                                {{item.name}}
                            </component>
                        </template>
                        <template v-else>
                            {{item.name}}
                        </template>
                    </li>
                </template>
                <!--                    <template v-else-if="item.divider">-->
                <!--                        <SidebarNavDivider :key="index" :classes="item.class"/>-->
                <!--                    </template>-->
                <!--                    <template v-else-if="item.label">-->
                <!--                        <SidebarNavLabel :key="index" :name="item.name" :url="item.url" :icon="item.icon" :label="item.label" :classes="item.class"/>-->
                <!--                    </template>-->
                <!--                    <template v-else>-->
                <!--                        <template v-if="item.children">-->
                <!--                            &lt;!&ndash; First level dropdown &ndash;&gt;-->
                <!--                            <SidebarNavDropdown :key="index" :name="item.name" :url="item.url" :icon="item.icon">-->
                <!--                                <template v-for="(childL1, index1) in item.children">-->
                <!--                                    <template v-if="childL1.children">-->
                <!--                                        &lt;!&ndash; Second level dropdown &ndash;&gt;-->
                <!--                                        <SidebarNavDropdown :key="index1" :name="childL1.name" :url="childL1.url" :icon="childL1.icon">-->
                <!--                                            <li :key="index2" class="nav-item" v-for="(childL2, index2) in childL1.children">-->
                <!--                                                <SidebarNavLink :name="childL2.name" :url="childL2.url" :icon="childL2.icon" :badge="childL2.badge" :variant="childL2.variant" :attributes="childL2.attributes" />-->
                <!--                                            </li>-->
                <!--                                        </SidebarNavDropdown>-->
                <!--                                    </template>-->
                <!--                                    <template v-else>-->
                <!--                                        <SidebarNavItem :key="index1" :classes="item.class">-->
                <!--                                            <SidebarNavLink :name="childL1.name" :url="childL1.url" :icon="childL1.icon" :badge="childL1.badge" :variant="childL1.variant" :attributes="childL1.attributes"/>-->
                <!--                                        </SidebarNavItem>-->
                <!--                                    </template>-->
                <!--                                </template>-->
                <!--                            </SidebarNavDropdown>-->
                <!--                        </template>-->
                <!--                        <template v-else>-->
                <!--                            <SidebarNavItem :key="index" :classes="item.class">-->
                <!--                                <SidebarNavLink :name="item.name" :url="item.url" :icon="item.icon" :badge="item.badge" :variant="item.variant" :attributes="item.attributes"/>-->
                <!--                            </SidebarNavItem>-->
                <!--                        </template>-->
                <!--                    </template>-->
            </template>
        </ul>

    </div>
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
    }

    .side-bar-close {
        width: 68px;
    }
</style>
