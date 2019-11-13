<template>
    <div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="card card-outline p-3">
                        <div class="col-lg-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">用户名称</span>
                                </div>
                                <input type="text" name="name" v-model="form.name"
                                       class="form-control" placeholder="角色名称">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">登录邮箱</span>
                                </div>
                                <input type="email" name="email"  v-model="form.email"
                                       class="form-control" placeholder="登录邮箱">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">登录密码</span>
                                </div>
                                <input type="password" name="password"  v-model="form.password" class="form-control" placeholder="登录密码">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">角色绑定</span>
                                </div>
                                <b-form-select v-model="form.role_id">
                                    <template v-slot:first>
                                        <option :value="null" disabled>-- 请选择角色进行绑定 --</option>
                                    </template>
                                    <template v-for="(role, i) in roles">
                                        <option :value="role.id">{{role.alias}}</option>
                                    </template>
                                </b-form-select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-group mt-3">
                                <button type="button" :disabled ="disabled" @click="onSubmit" class="btn btn-block btn-outline-primary col-4">
                                    提交
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <alert :alerts="alerts"/>
    </div>
</template>

<script>
    import { getDetail, updateData, createData } from '../../api/admin'
    import { getAll } from '../../api/role'
    import Alert from '../../components/alert/Index'

    export default {
        name: 'AdminEdit',
        components:{
            Alert
        },
        props: {
            isEdit: {
                type: Boolean,
                default: true
            }
        },
        data() {
            return {
                disabled: true,
                alerts: [],
                tempRoute: {},
                form: {
                    id: null,
                    role_id: null,
                    name: null,
                    email: null,
                    password: null,
                    avatar: null
                },
                roles: [],
            }
        },
        methods: {
            checkEmail: function (value) {
                let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                let email = reg.test(value);
                email ? void(0) : this.alerts.push({'type': 'danger','msg': '请输入正确的邮箱地址','show': 10,'down': 0 });
                return email;
            },
            checkPassword: function (value) {
                let password = value === null ? false : (value.length >= 6 && value.length <= 32);
                password ? void(0) : this.alerts.push({'type': 'danger','msg': '密码应为长度 6 - 32 位的字符串','show': 10,'down': 0 });
                return password;
            },
            checkForm(){
                if(this.isEdit && !this.form.id){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '参数获取失败'});
                    return false;
                }
                if(!this.form.name){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入用户名'});
                    return false;
                }
                if(!this.form.role_id){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请选择绑定角色'});
                    return false;
                }
                if(!this.form.email){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入登录邮箱'});
                    return false;
                }
                if(!this.form.password){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入登录密码'});
                    return false;
                }
                return true;
            },
            onSubmit() {
                if(this.checkForm()){
                    this.isEdit ? this.updateData() : this.createData()
                }
            },
            createData(){
                this.disabled = true
                createData(this.form).then(response => {
                    this.disabled = false
                    this.alerts.push({'type': response.data.msg_type,'show': 10,'down': 0,'msg': response.data.msg});
                }).catch(error => {
                    this.disabled = false
                    let error_message = error.response.data.message || error.message
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error_message)
                })
            },
            updateData(){
                this.disabled = true
                updateData(this.form).then(response => {
                    this.disabled = false
                    this.alerts.push({'type': response.data.msg_type,'show': 10,'down': 0,'msg': response.data.msg});
                }).catch(error => {
                    this.disabled = false
                    let error_message = error.response.data.message || error.message
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error_message)
                })
            },
            getDetail(){
                getDetail(this.form.id).then(response => {
                    if(response.data.code == 0){
                        this.form = response.data.data;
                        this.form.password = null
                    }else{
                        this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0});
                    }
                }).catch(error => {
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0 });
                    console.log(error);
                })
            },
            setTagsViewTitle() {
                const title = '用户编辑';
                const route = Object.assign({},  this.tempRoute, { title: `${title}-${this.form.id}` })
                this.$store.dispatch('updateVisitedView', route)
            },
            setPageTitle() {
                const title = '用户编辑';
                document.title = `${title} - ${this.form.id}`
            },
            getRole(){
                getAll().then(response => {
                    if(response.data.code == 0){
                        this.roles = response.data.data
                        this.disabled = false
                    }else{
                        this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0});
                    }
                }).catch(error => {
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0 });
                    console.log(error);
                })
            }
        },
        created(){
            this.getRole()
            if(this.isEdit){
                this.form.id = this.$route.params.id
                this.tempRoute = Object.assign({}, this.$route)

                // set tagsview title
                this.setTagsViewTitle()

                // set page title
                this.setPageTitle()

                this.getDetail()
            }else{
                this.disabled = false
            }
        },
    }
</script>

<style lang="scss" scoped>
    .img-avatar {
        height: 22px;
        margin: 0 10px;
        max-width: 100%;
        border-radius: 50%;
    }
</style>
