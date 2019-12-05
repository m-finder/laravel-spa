<template>
    <b-modal centered :title="title" v-model="show" @hidden="resetModal">
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

        <div slot="modal-footer" class="w-100">
            <b-button variant="primary" size="sm" @click="resetModal">取消</b-button>
            <b-button variant="danger" size="sm" @click="submitCreate">确认</b-button>
        </div>
    </b-modal>
</template>

<script>
    import {createData} from "../../api/admin";
    import {getAll} from "../../api/role";

    const defaultForm = {
        name: null,
        email: null,
        password: null,
        role_id: null,
    };
    export default {
        name: "AdminCreate",
        props: {
            'is-create': {
                type: Boolean,
                default: false
            },
            title: {
                type: String,
                default: '添加操作'
            }
        },
        data() {
            return {
                alerts: [],
                form: Object.assign({}, defaultForm),
                show: this.isCreate,
                roles: [],
            }
        },
        watch: {
            isCreate(value){
                this.show = value;
                this.getRole();
            }
        },
        methods: {
            getRole(){
                getAll().then(response => {
                    if(response.data.code == 0){
                        this.roles = response.data.data;
                    }else{
                        this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0});
                    }
                }).catch(error => {
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0 });
                    console.log(error);
                })
            },
            checkForm() {
                if(!this.form.name){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入用户名'});
                    return false;
                }
                if(!this.form.role_id){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请选择绑定角色'});
                    return false;
                }
                if(!this.form.email){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入登录邮箱'});
                    return false;
                }
                let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                let email = reg.test(this.form.email);
                if(!email){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入正确的登录邮箱'});
                    return false;
                }
                if(!this.form.password){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入登录密码'});
                    return false;
                }
                if(this.form.password.length > 32 || this.form.password.length<6){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '密码应为长度 6 - 32 位的字符串'});
                    return false;
                }
                return true;
            },
            submitCreate() {
                if (this.checkForm()) {
                    createData(this.form).then(response => {
                        this.$parent.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0 });
                        if (response.data.code == 0) {
                            this.$parent.getList();
                            this.resetModal()
                        }
                    }).catch((error) => {
                        this.$parent.alerts.push({'type': 'danger', 'msg': error.toString(), 'show': 10, 'down': 0});
                        console.log(error)
                    })
                }
            },
            resetModal() {
                this.form = Object.assign({}, defaultForm);
                this.show = false;
                this.$parent.isCreate = false;
            }
        }
    }
</script>

<style scoped>

</style>
