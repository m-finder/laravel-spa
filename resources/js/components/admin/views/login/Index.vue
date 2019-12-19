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
                                    <span>Laravel  Admin  </span><span class="subtitle">spa</span>
                                </a>
                            </div>
                        </div>
                        <b-form @submit="onSubmit" class="login-form">
                            <b-form-input v-model="form.email" :state="emailState"
                                          aria-describedby="input-live-help email-feedback" placeholder="登录邮箱" trim/>
                            <b-form-invalid-feedback id="email-feedback">
                                {{ error.email }}
                            </b-form-invalid-feedback>
                            <b-form-input type="password" v-model="form.password" :state="passwordState"
                                          aria-describedby="input-live-help password-feedback" placeholder="登录密码"
                                          trim/>
                            <b-form-invalid-feedback id="password-feedback">
                                {{ error.password }}
                            </b-form-invalid-feedback>
                            <b-button type="submit" block variant="outline-primary" :disabled="disabled">
                                <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                                {{ text }}
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
                                <span>Laravel  Admin  </span><span class="subtitle">spa</span>
                            </a>
                        </div>
                        <b-form @submit="onForgetSubmit" class="forget-form">
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
                                    <b-button type="submit" block variant="outline-primary" :disabled="disabled">
                                        <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                                        {{ text }}
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
    import {login} from '../../api/login'
    import storage from '../../utils/storage'
    export default {
        name: 'Login',
        data() {
            return {
                text: '登录',
                loading: false,
                disabled: false,
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
                handler: function(route) {
                    const query = route.query
                    if (query) {
                        this.redirect = query.redirect
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
                    // this.$refs['ruleForm'].resetFields()
                    // this.$refs['forgetRuleForm'].resetFields()
                }, 300)
            },
            checkEmail: function (value) {
                let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                let email = reg.test(value);
                this.error.email = email ? null : '请输入正确的邮箱地址';
                this.emailState = email ? true : false;
                if (!email) {
                    this.restForm()
                }
                return email;
            },
            checkPassword: function (value) {
                let password = value === null ? false : (value.length >= 6 && value.length <= 32);
                this.error.password = password ? null : '密码应为长度 6 - 32 位的字符串';
                this.passwordState = password ? true : false;
                if (!password) {
                    this.restForm()
                }
                return password;
            },
            onSubmit: function (evt) {
                evt.preventDefault();
                this.loginSubmit();
                let email = this.form.email;
                let password = this.form.password;
                let emailCheck = this.checkEmail(email);
                let passwordCheck = this.checkPassword(password);
                if (emailCheck && passwordCheck) {
                    login(this.form).then(res => {
                        if (res.data.code == 0) {
                            this.$toast.success(res.data.msg, 'Success');
                            let data = {'user-info': res.data.data, 'token': res.data.data.api_token};
                            this.form.status === true ? storage.set(data) : (storage.remove(), storage.sessionSet(data));
                            this.$router.push({path: this.redirect || '/'})
                        } else {
                            this.restForm();
                            this.$toast.error(res.data.msg, 'Error')
                        }
                    })
                }
            },
            onForgetSubmit: function (evt) {
                evt.preventDefault();
                console.log(this.forgetForm)
            },
            loginSubmit: function () {
                this.loading = true;
                this.disabled = true;
                this.text = '登录中...';
            },
            restForm: function () {
                this.loading = false;
                this.disabled = false;
                this.text = '登录';
            }
        }
    }
</script>

<style lang="scss" scoped>
    /*
        login.scss 在这里直接 import 的话，页面刷新时会闪烁
        全部复制到这里的话，图片地址不好处理
     */
</style>
