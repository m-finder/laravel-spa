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
            <b-button :disabled="disabled" variant="danger" size="sm" @click="submitUpdate">确认</b-button>
        </div>
    </b-modal>
</template>

<script>
    import {getDetail, updateData} from "../../api/element";

    const defaultForm = {
        id: null,
        name: null,
        code: null,
        method: 'get',
        path: null,
    };
    export default {
        name: "ElementEdit",
        data (){
            return {
                form: Object.assign({}, defaultForm),
                show: false,
                disabled: true
            }
        },
        props:{
            id: {
                default: null
            },
            'is-edit': {
                type: Boolean,
                default: false
            },
            title: {
                type: String,
                default: '添加操作'
            }
        },
        watch:{
            id(){},
            isEdit(value){
                this.show = value;
                if(value){
                    this.disabled = true;
                    this.getDetail();
                }
            }
        },
        methods: {
            getDetail(){
                getDetail(this.id).then(res => {
                    this.form = res.data;
                    this.disabled = false;
                })
            },
            checkForm(){
                if(!this.form.menu_id){
                    this.$toast.warning('菜单数据获取失败，请重试', 'Warning');
                    return false;
                }
                if(!this.form.name){
                    this.$toast.warning('请输入资源名称', 'Warning');
                    return false;
                }
                if(!this.form.code){
                    this.$toast.warning('请输入资源编号', 'Warning');
                    return false;
                }
                if(!this.form.method){
                    this.$toast.warning('请选择请求方法', 'Warning');
                    return false;
                }
                if(!this.form.path){
                    this.$toast.warning('请输入请求路径', 'Warning');
                    return false;
                }
                return true;
            },
            submitUpdate(){
                if(this.checkForm()){
                    updateData(this.form).then(res => {
                        this.$toast.success(res.msg, 'Success');
                        this.$parent.getList();
                        this.resetModal();
                    })
                }
            },
            resetModal(){
                this.form = Object.assign({}, defaultForm);
                this.show = false;
                this.$parent.isEdit = false;
            }
        }
    }
</script>

<style scoped>

</style>