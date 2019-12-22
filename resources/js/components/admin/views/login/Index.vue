<template>
    <b-container class="login-page" fluid>
        <b-container class="login-wrap">
            <b-row>
                <b-col :class="translateLeft" :sm="12" :xs="12" :md="5" :lg="5" :xl="5">
                    <div v-if="notForget">
                        <div class="logo">
                            <img src="/favicon.ico" alt="">
                            <div class="title">
                                <a>
                                    <span>{{ config.title }}  </span><span class="subtitle">{{ config.subheading }}</span>
                                </a>
                            </div>
                        </div>

                        <b-form class="login-form">
                            <b-form-input v-model="form.email" :state="emailState" aria-describedby="input-live-help email-feedback" placeholder="登录邮箱" trim/>
                            <b-form-invalid-feedback id="email-feedback">
                                {{ error.email }}
                            </b-form-invalid-feedback>
                            <b-form-input type="password" v-model="form.password" :state="passwordState" aria-describedby="input-live-help password-feedback" placeholder="登录密码" trim/>
                            <b-form-invalid-feedback id="password-feedback">
                                {{ error.password }}
                            </b-form-invalid-feedback>

                            <b-button @click="onSubmit" block variant="outline-primary" :disabled="disabled">
                                <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                                登录
                            </b-button>

                            <b-row class="rember-box">
                                <b-col>
                                    <b-form-checkbox v-model="form.status">
                                        记住我
                                    </b-form-checkbox>
                                </b-col>
                                <b-col class="text-right">
                                    <a class="forget" @click="wrapSwitch(false)">忘记密码？</a>
                                </b-col>
                            </b-row>
                        </b-form>
                    </div>

                    <!-- 忘记密码 -->
                    <div v-else>
                        <div class="title forget-wrap-title">
                            <a>
                                <span>{{ config.title }}  </span><span class="subtitle">{{ config.subheading }}</span>
                            </a>
                        </div>
                        <b-form class="forget-form">
                            <b-form-input v-model="forgetForm.email" :state="forgetEmailState"
                                          aria-describedby="input-live-help forget-email-feedback" placeholder="登录邮箱"
                                          trim/>
                            <b-form-invalid-feedback id="forget-email-feedback">
                                {{ error.forgetEmail }}
                            </b-form-invalid-feedback>
                            <b-form-input type="password" v-model="form.password" :state="forgetPasswordState"
                                          aria-describedby="input-live-help forget-password-feedback" placeholder="登录密码"
                                          trim/>
                            <b-form-invalid-feedback id="forget-password-feedback">
                                {{ error.forgetPassword }}
                            </b-form-invalid-feedback>
                            <b-row class="rember-box">
                                <b-col>
                                    <b-button type="button" block @click="wrapSwitch(true)" variant="outline-primary">
                                        返回
                                    </b-button>
                                </b-col>
                                <b-col class="text-right">
                                    <b-button @click="onForgetSubmit" block variant="outline-primary" :disabled="forgetDisabled">
                                        忘记密码
                                    </b-button>
                                </b-col>
                            </b-row>
                        </b-form>
                    </div>
                </b-col>
                <b-col :class="translateRight" :sm="0" :xs="0" :md="7" :lg="7" :xl="7">
                    <div class="wallpaper"/>
                </b-col>
            </b-row>
        </b-container>
    </b-container>
</template>

<script>
    import {login} from '../../api/login';
    import storage from '../../utils/storage';
    import config from '../../config/config';

    export default {
        name: 'Login',
        data() {
            return {
                config: config,
                loading: false,
                disabled: false,
                forgetDisabled: false,
                switchLeft: false,
                notForget: true,
                alerts: [],
                form: {
                    email: null,
                    password: null,
                    status: true
                },
                error: {
                    email: '',
                    password: '',
                    forgetEmail: '',
                    forgetPassword: ''
                },
                emailState: null,
                passwordState: null,
                forgetEmailState: null,
                forgetPasswordState: null,
                forgetForm: {
                    email: null
                },
                redirect: null,
                otherQuery: {}
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
                value.length === 0 ? this.emailState = this.error.email = null : this.checkEmail(value)
            },
            'form.password': function (value) {
                value.length === 0 ? this.passwordState = this.error.password = null : this.checkPassword(value)
            },
            $route: {
                handler: function (route) {
                    const query = route.query;
                    if (query) {
                        this.redirect = query.redirect;
                        this.otherQuery = this.getOtherQuery(query)
                    }
                },
                immediate: true
            }
        },
        methods: {
            getOtherQuery(query) {
                return Object.keys(query).reduce((acc, cur) => {
                    if (cur !== 'redirect') {
                        acc[cur] = query[cur]
                    }
                    return acc
                }, {})
            },
            wrapSwitch(state) {
                this.switchLeft = !this.switchLeft;
                this.switchRight = !this.switchRight;
                setTimeout(() => {
                    this.notForget = state
                }, 300)
            },
            checkEmail: function () {
                let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                let email = reg.test(this.form.email);
                email ?
                    (this.error.email = null, this.emailState = true) :
                    (this.error.email = '请输入正确的邮箱地址', this.emailState = this.loading =  this.disabled = false);
                return email;
            },
            checkPassword: function () {
                let value = this.form.password;
                let password = value === null ? false : (value.length >= 6 && value.length <= 32);
                password ?
                    (this.error.password = null, this.passwordState = true) :
                    (this.passwordState = this.loading =  this.disabled = false, this.error.password = '密码应为长度 6 - 32 位的字符串');
                return password;
            },
            onSubmit: function () {
                this.loading =  this.disabled = true;
                let email = this.checkEmail(), pwd = this.checkPassword();
                if (email && pwd) {
                    login(this.form).then(res => {
                        this.loading =  this.disabled = false;
                        this.$toast.success('欢迎回来', 'Success');
                        this.$store.dispatch('ClearRoutes');
                        let data = {'user-info': res.data, 'token': res.data.api_token};
                        this.form.status === true ? storage.set(data) : (storage.remove(), storage.sessionSet(data));
                        this.$router.push({path: this.redirect || '/'})
                    }).catch(error => {
                        this.loading =  this.disabled = false;
                        this.$toast.error(error.response.data.message, 'Error');
                    })
                }
            },
            onForgetSubmit: function () {
                console.log(this.forgetForm)
            },
        }
    }
</script>

<style lang="scss" scoped>
    /*
        login.scss 在这里直接 import 的话，页面刷新时会闪烁
        全部复制到这里的话，图片地址不好处理
     */
</style>
