<template>
    <section class="nav-wrap">
        <header class="header navbar">
            <button class="d-lg-none navbar-toggler" type="button" display="md" mobile @click="toggleSideBar">
                <svg-vue class="nav-status " icon="menu"/>
            </button>

            <button class="bv-d-md-down-none navbar-toggler" type="button" display="lg" @click="toggleSideBar">
                <svg-vue class="nav-status " icon="menu"/>
            </button>

            <button class="bv-d-lg-none navbar-toggler" type="button" display="md" @click="refresh">
                <svg-vue class="nav-status " icon="refresh"/>
            </button>

            <bread-crumb class="mr-auto p-0 " :list="list"/>

            <b-navbar class="justify-content-end p-0 bv-d-md-down-none">
                <b-navbar-nav>
                    <b-nav-item>
                        <svg-vue icon="message"/>
                        <b-badge pill variant="danger">5</b-badge>
                    </b-nav-item>

                    <b-nav-item-dropdown class="bv-d-md-down-none ml-2 mr-2" right>
                        <template v-slot:button-content>
                            <img :src="'/images/avatar.png'" class="img-avatar" alt=""/>
                        </template>
                        <b-dropdown-item href="#">资料设置</b-dropdown-item>
                        <b-dropdown-item href="#">密码设置</b-dropdown-item>
                        <b-dropdown-item href="#">退出登陆</b-dropdown-item>
                    </b-nav-item-dropdown>
                    <b-nav-item @click="showSideBar = !showSideBar">
                        <svg-vue icon="setting"/>
                    </b-nav-item>
                </b-navbar-nav>
            </b-navbar>
        </header>

        <div class="theme-box" :class="{'show-theme-box': showSideBar}">
            <p>主题设置</p>
            <div class="close-btn" @click="showSideBar = false">
                <svg-vue icon="close"/>
            </div>
            <div>
                <b-button variant="outline-success" @click="setTheme('default')" block>default</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-dark-blue')" block>dark-blue</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-light-blue')" block>light-blue</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-light-green')" block>light-green</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-light-red')" block>light-red</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-blue')" block>blue</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-indigo')" block>indigo</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-purple')" block>purple</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-red')" block>red</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-pink')" block>pink</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-orange')" block>orange</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-yellow')" block>yellow</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-green')" block>green</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-teal')" block>teal</b-button>
                <b-button variant="outline-success" @click="setTheme('bg-cyan')" block>cyan</b-button>
            </div>
        </div>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex'
    import storage from '../../../../storage'
    import BreadCrumb from '../../breadcrumb/Index'

    export default {
        components: {
            'bread-crumb': BreadCrumb
        },
        data() {
            return {
                userInfo: storage.get('user-info') || storage.sessionGet('user-info'),
                showSideBar: false
            }
        },
        computed: {
            ...mapGetters([
                'sidebar',
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
            toggleSideBar() {
                this.$store.dispatch('app/toggleSideBar')
            },
            refresh() {
                this.$store.dispatch('delCachedView', this.$route).then(() => {
                    const {fullPath} = this.$route
                    this.$nextTick(() => {
                        this.$router.replace({
                            path: '/redirect' + fullPath
                        })
                    })
                })
            },
            setTheme(className) {
                this.$store.dispatch('app/changeTheme', className)
            },
            getName(item) {
                return item.meta && item.meta.label ? item.meta.label : item.name || null
            },
            isLast(index) {
                return index === this.list.length - 1
            },
        }
    }
</script>

<style lang="scss" scoped>
    .nav-wrap {
        box-shadow: 0 1px 4px rgba(0, 21, 41, .08);
    }


    .navbar-toggler {
        outline: none;

        .nav-status {
            width: 20px;
            height: 20px;
            cursor: pointer;
            fill: #666;
        }
    }

    .img-avatar {
        height: 22px;
        margin: 0 10px;
        max-width: 100%;
        border-radius: 50%;
    }

    .nav-item {
        position: relative;

        .badge {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -16px;
            margin-left: 0;
        }
    }

    .theme-box {
        width: 250px;
        height: calc(100vh - 90px);
        position: fixed;
        right: -300px;
        bottom: 0;
        background: rgba(255, 255, 255, .8);
        z-index: 1027;
        padding: 25px;
        transition: all 0.2s;
        .close-btn {
            position: absolute;
            left: -35px;
            top: 0;
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, .8);
            text-align: center;
            line-height: 35px;

            &:hover {
                svg {
                    fill: #e3342f;
                }
            }
        }
    }
    .show-theme-box{
        right: 0;
    }
</style>
