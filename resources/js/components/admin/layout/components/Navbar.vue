<template>
    <section class="nav-wrap">
        <header class="header navbar">
            <button class="d-lg-none navbar-toggler" type="button" display="md" mobile @click="toggleSideBar">
                <svg-vue class="nav-status " icon="menu"/>
            </button>

            <button class="bv-d-md-down-none navbar-toggler" type="button" display="lg" @click="toggleSideBar">
                <svg-vue class="nav-status " icon="menu"/>
            </button>

            <b-navbar class="mr-auto p-0 bv-d-md-down-none">
                <b-navbar-nav>
                    <b-nav-item class="px-3" href="#">Link</b-nav-item>
                    <b-nav-item class="px-3" href="#" disabled>Disabled</b-nav-item>
                </b-navbar-nav>
            </b-navbar>

            <b-navbar class="justify-content-end p-0 bv-d-md-down-none">
                <b-navbar-nav>
                    <b-nav-item>
                        <svg-vue icon="message"/>
                        <b-badge pill variant="danger">5</b-badge>
                    </b-nav-item>

                    <b-nav-item-dropdown class="bv-d-md-down-none" right>
                        <template v-slot:button-content>
                            <img :src="'/images/avatar.png'" class="img-avatar" alt=""/>
                        </template>
                        <b-dropdown-item href="#">资料设置</b-dropdown-item>
                        <b-dropdown-item href="#">密码设置</b-dropdown-item>
                        <b-dropdown-item href="#">退出登陆</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-navbar>
        </header>
    </section>
</template>
<script>
    import {mapGetters} from 'vuex'
    import storage from '../../../../storage'

    export default {
        data() {
            return {
                userInfo: storage.get('user-info') || storage.sessionGet('user-info')
            }
        },
        computed: {
            ...mapGetters([
                'sidebar',
            ]),
            isCollapse() {
                return this.sidebar.opened
            }
        },
        methods: {
            toggleSideBar() {
                this.$store.dispatch('app/toggleSideBar')
            },
        }
    }
</script>

<style lang="scss" scoped>
    .nav-wrap {
        /*background: #ffffff;*/
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
    .nav-item{
        position: relative;
        .badge{
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -16px;
            margin-left: 0;
        }
    }
</style>
