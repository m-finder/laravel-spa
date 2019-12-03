<template>
    <div class="theme-box" :class="{'show-theme-box': show}">
        <p>
            <svg-vue icon="theme"/>
            <span>主题设置</span>
        </p>
        <div class="close-btn" @click="close">
            <svg-vue icon="close"/>
        </div>
        <div>
            <div class="current-theme-box">
                当前主题:
                <div :class="[currentTheme, 'theme-btn']"></div>
            </div>
            <div class="theme-btn default" @click="setTheme('default')"></div>
            <div class="theme-btn bg-dark-blue" @click="setTheme('bg-dark-blue')"></div>
            <div class="theme-btn bg-light-blue" @click="setTheme('bg-light-blue')"></div>
            <div class="theme-btn bg-light-green" @click="setTheme('bg-light-green')"></div>
            <div class="theme-btn bg-light-red" @click="setTheme('bg-light-red')"></div>
            <div class="theme-btn bg-blue" @click="setTheme('bg-blue')"></div>
            <div class="theme-btn bg-indigo" @click="setTheme('bg-indigo')"></div>
            <div class="theme-btn bg-purple" @click="setTheme('bg-purple')"></div>
            <div class="theme-btn bg-red" @click="setTheme('bg-red')"></div>
            <div class="theme-btn bg-pink" @click="setTheme('bg-pink')"></div>
            <div class="theme-btn bg-orange" @click="setTheme('bg-orange')"></div>
            <div class="theme-btn bg-yellow" @click="setTheme('bg-yellow')"></div>
            <div class="theme-btn bg-green" @click="setTheme('bg-green')"></div>
            <div class="theme-btn bg-teal" @click="setTheme('bg-teal')"></div>
            <div class="theme-btn bg-cyan" @click="setTheme('bg-cyan')"></div>
        </div>
    </div>
</template>

<script>
    import storage from '../../../../../storage'

    export default {
        name: "theme",
        data() {
            return {
                currentTheme: storage.get('theme')
            }
        },

        props: {
            show: {
                type: Boolean,
                default: false
            }
        },
        methods: {
            close: function (e) {
                this.$parent.showSideBar = false
            },
            setTheme(className) {
                this.currentTheme = className;
                this.$store.dispatch('app/changeTheme', className)
            },
        }
    }
</script>

<style lang="scss" scoped>
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
            cursor: pointer;

            &:hover {
                svg {
                    fill: #e3342f;
                }
            }
        }
    }

    .show-theme-box {
        right: 0;
    }

    .theme-btn {
        width: 25px;
        height: 25px;
        margin-right: 10px;
        cursor: pointer;
        display: inline-block;
    }

    .current-theme-box {
        margin: 15px auto;

        .theme-btn {
            cursor: default;
            vertical-align: bottom;
        }
    }
</style>
