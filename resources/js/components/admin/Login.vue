<template>
    <div class="login-page">
        <div class="login-wrap">
            <b-container>
                <b-row>
                    <b-col :class="translateLeft" :sm="12" :xs="12" :md="5" :lg="5" :xl="5">
                        <div class="logo">
                            <img src="/favicon.ico" alt="">
                            <div class="title">
                                <a>
                                    <span>Laravel  Admin  </span><span class="subtitle">spa</span>
                                </a>
                            </div>
                        </div>
                        <div class="login-form">
                            <b-form>
                                <label class="sr-only" for="email">登录邮箱</label>
                                <b-input id="email" class="mb-2 mr-sm-2 mb-sm-0" placeholder="登录邮箱"
                                         aria-describedby="input-live-help email-feedback" :state="emailState"/>
                                <b-form-invalid-feedback id="email-feedback">
                                    Enter at least 3 letters
                                </b-form-invalid-feedback>
                            </b-form>
                        </div>
                    </b-col>
                    <b-col :class="translateRight" :sm="0" :xs="0" :md="7" :lg="7" :xl="7">
                        <div class="wallpaper"/>
                    </b-col>
                </b-row>
            </b-container>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                switchLeft: false,
                form: {
                    email: null
                }
            }
        },
        computed: {
            emailState(){
                return false
            },
            translateLeft() {
                return {
                    'translate-left': true,
                    'login-col': true,
                    'switch-left': this.switchLeft
                }
            },
            translateRight() {
                return {
                    'translate-right': true,
                    'login-col': true,
                    'switch-right': this.switchLeft
                }
            }
        },
        watch: {
            $route: {
                handler: function (route) {
                    // 第三步 获取重定向路由
                    this.redirect = route.query && route.query.redirect
                },
                immediate: true
            }
        },
    }
</script>

<style lang="scss" scoped>
    @import "/css/login.css";
</style>
