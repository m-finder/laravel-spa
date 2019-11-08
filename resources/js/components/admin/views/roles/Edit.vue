<template>
    <div>
        <div class="card-body">
            <b-form :model="form" @submit.stop.prevent="onSubmit">
                <div class="row">
                    <div class="col-6">
                        <div class="card card-outline p-3">
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">角色名称</span>
                                    </div>
                                    <input required type="text" name="name" v-model="form.name"
                                           class="form-control" placeholder="角色名称">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">角色别名</span>
                                    </div>
                                    <input required type="text" name="alias"  v-model="form.alias"
                                           class="form-control" placeholder="登录邮箱">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="input-group mt-3">
                                    <button type="submit" class="btn btn-block btn-outline-primary col-4">
                                        提交
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </b-form>
        </div>
        <alert :alerts="alerts"/>
    </div>
</template>

<script>
    import { getDetail, updateData } from '../../../../api/role'
    import Alert from '../../components/alert/Index'

    export default {
        components:{
            Alert
        },
        data() {
            return {
                alerts: [],
                form: {
                    id: this.$route.params.id,
                    name: null,
                    alias: null
                }
            }
        },
        methods: {
            checkForm(){
                if(!this.form.id){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '参数获取失败'});
                    return false;
                }
                if(!this.form.name){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入角色名'});
                    return false;
                }
                if(!this.form.alias){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入角色别名'});
                    return false;
                }
                return true;
            },
            onSubmit() {
                if(this.checkForm()){
                    updateData(this.form).then(response => {
                        this.alerts.push({'type': response.data.msg_type,'show': 10,'down': 0,'msg': response.data.msg});
                    }).catch(error => {
                        let error_message = error.response.data.message || error.message
                        this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                        console.log(error_message)
                    })
                }
            },
            getDetail(){
                getDetail(this.form.id).then(response => {
                    if(response.data.code == 0){
                        this.form = response.data.data
                    }else{
                        this.alerts.push({
                            'type': response.data.msg_type,
                            'msg': response.data.msg,
                            'show': 10,
                            'down': 0
                        });
                    }
                }).catch(error => {
                    this.alerts.push({
                        'type': 'danger',
                        'msg': '系统出错，请联系管理员查看',
                        'show': 10,
                        'down': 0
                    });
                    console.log(error);
                })
            }
        },
        mounted() {
            this.getDetail()
        }
    }
</script>

<style scoped>

</style>
