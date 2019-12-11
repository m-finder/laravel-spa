<template>
    <b-modal centered :title="title" v-model="show" @hidden="resetModal">
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">资源名称</span>
                </div>
                <b-form-input v-model="form.name" placeholder="请输入资源名称"/>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">资源编号</span>
                </div>
                <b-form-input v-model="form.code" placeholder="请输入资源编号"/>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">请求方法</span>
                </div>
                <b-form-select v-model="form.method">
                    <template v-slot:first>
                        <option :value="null" disabled>-- 请选择请求方法 --</option>
                    </template>
                    <option value="get">GET</option>
                    <option value="post">POST</option>
                    <option value="put">PUT</option>
                    <option value="deleet">DELETE</option>
                </b-form-select>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">请求路径</span>
                </div>
                <b-form-input v-model="form.path" placeholder="请求路径"/>
            </div>
        </div>


        <div slot="modal-footer" class="w-100">
            <b-button variant="primary" size="sm" @click="resetModal">取消</b-button>
            <b-button variant="danger" size="sm" @click="submitCreate">确认</b-button>
        </div>
    </b-modal>
</template>

<script>
    import {createData} from "../../api/element";

    const defaultForm = {
        router_id: null,
        name: null,
        code: null,
        method: 'get',
        path: null,
    };
    export default {
        name: "ElementCreate",
        data (){
            return {
                form: Object.assign({}, defaultForm),
                show: false
            }
        },
        props:{
            'router-id': {
                default: null
            },
            'is-create': {
                type: Boolean,
                default: false
            },
            title: {
                type: String,
                default: '添加操作'
            }
        },
        watch:{
            isCreate(value){
                this.form.router_id = this.routerId;
                this.show = value;
            }

        },
        methods: {
            checkForm(){
                if(!this.form.router_id){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '菜单数据获取失败，请重试'});
                    return false;
                }
                if(!this.form.name){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入资源名称'});
                    return false;
                }
                if(!this.form.code){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入资源编号'});
                    return false;
                }
                if(!this.form.method){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请选择请求方法'});
                    return false;
                }
                if(!this.form.path){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入请求路径'});
                    return false;
                }
                return true;
            },
            submitCreate(){
                if(this.checkForm()){
                    createData(this.form).then(response => {
                        this.$parent.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0 });
                        if (response.data.code == 0) {
                            this.$parent.getList();
                            this.resetModal();
                        }
                    }).catch((error) => {
                        this.$parent.alerts.push({'type': 'danger', 'msg': error.toString(), 'show': 10, 'down': 0});
                        console.log(error)
                    })
                }
            },
            resetModal(){
                this.form = Object.assign({}, defaultForm);
                this.show = false;
                this.$parent.isCreate = false;
            }
        }
    }
</script>

<style scoped>

</style>