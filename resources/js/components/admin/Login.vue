<template>
    <div class="login-page">
        <div class="login-wrap">
            <b-container :class="translateLeft" >
                <b-row>
                    <b-col :sm="12" :xs="12" :md="5" :lg="5" :xl="5">
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
                                <b-form-group>
                                    <label class="sr-only" for="email">登录邮箱</label>
                                    <b-input id="email" v-model="form.email" class="mb-2 mr-sm-2 mb-sm-0" placeholder="登录邮箱" aria-describedby="input-live-help email-feedback" :state="emailState"/>
                                    <b-form-invalid-feedback id="email-feedback" v-cloak>
                                        {{ error.email }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
                                <b-form-group>
                                    <label class="sr-only" for="password">登录密码</label>
                                    <b-input id="password" v-model="form.password" class="mb-2 mr-sm-2 mb-sm-0" placeholder="登录密码" aria-describedby="input-live-help password-feedback" :state="passwordState"/>
                                    <b-form-invalid-feedback id="password-feedback" v-cloak>
                                        {{ error.password }}
                                    </b-form-invalid-feedback>
                                </b-form-group>
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
                    email: null,
                    password: null
                },
                error: {
                    email: '',
                    password: ''
                },
                emailState: null,
                passwordState: null
            }
        },
        computed: {
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
            'form.email': function (value) {
                let reg = /^[A-Za-z0-9\u4e00-\u9fa5]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
                if (value.length > 0 && !reg.test(value)) {
                    this.error.email = '请输入正确的邮箱地址';
                    this.emailState = false
                } else {
                    this.emailState = true
                }
            },
            'form.password': function (value) {
                if (value.length > 32 || value.length < 6) {
                    this.error.password = '密码应为长度 6 - 32 位的字符串';
                    this.passwordState = false
                } else {
                    this.passwordState = true
                }
            },
            $route: {
                handler: function (route) {
                    // 第三步 获取重定向路由
                    this.redirect = route.query && route.query.redirect
                },
                immediate: true
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "/css/login.css";
    [v-cloak] {
        display: none;
    }
</style>
