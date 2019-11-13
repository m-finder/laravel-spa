<template>
    <div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="card card-outline p-3">
                        <div class="col-lg-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">角色名称</span>
                                </div>
                                <input type="text" name="name" v-model="form.name"
                                       class="form-control" placeholder="角色名称">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">角色别名</span>
                                </div>
                                <input type="text" name="alias"  v-model="form.alias"
                                       class="form-control" placeholder="角色别名">
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
    import { getDetail, updateData, createData } from '../../api/role'
    import Alert from '../../components/alert/Index'

    export default {
        name: 'RoleEdit',
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
                    name: null,
                    alias: null
                }
            }
        },
        methods: {
            checkForm(){
                if(this.isEdit && !this.form.id){
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
                        this.disabled = false
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
            },
            setTagsViewTitle() {
                const title = '角色编辑'
                const route = Object.assign({},  this.tempRoute, { title: `${title}-${this.form.id}` })
                this.$store.dispatch('updateVisitedView', route)
            },
            setPageTitle() {
                const title = '角色编辑'
                document.title = `${title} - ${this.form.id}`
            },
        },
        created(){
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

<style scoped>

</style>
