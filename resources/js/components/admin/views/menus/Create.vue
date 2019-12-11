<template>
    <b-modal centered :title="title" v-model="show" @hidden="resetModal">
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">上级菜单</span>
                </div>
                <b-form-select v-model="form.parent_id">
                    <template v-slot:first>
                        <option :value="null" disabled>-- 请选择上级菜单 --</option>
                    </template>
                    <option :value="parents.id">{{ parents.title }}</option>
                </b-form-select>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">视图名称</span>
                </div>
                <b-form-input v-model="form.name" placeholder="请输入视图名称(vue 组件 name)" required/>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">菜单名称</span>
                </div>
                <b-form-input v-model="form.title" placeholder="请输入菜单名称" required/>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">视图路径</span>
                </div>
                <b-form-input v-model="form.component" placeholder="请输入视图文件路径" required/>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">跳转地址</span>
                </div>
                <b-form-input v-model="form.path" placeholder="请输入跳转地址" required/>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">重定向&nbsp;&nbsp;&nbsp;</span>
                </div>
                <b-form-input v-model="form.redirect" placeholder="请输入重定向地址"/>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">图标文件</span>
                </div>
                <b-form-input v-model="form.icon" placeholder="请输入图标文件"/>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">排序编号</span>
                </div>
                <b-form-input v-model="form.order_num" placeholder="请输入排序编号，从小到大正序排列"/>
            </div>
        </div>

        <div slot="modal-footer" class="w-100">
            <b-button variant="primary" size="sm" @click="resetModal">取消</b-button>
            <b-button variant="danger" size="sm" @click="submitCreate">确认</b-button>
        </div>
    </b-modal>
</template>

<script>
    import {createData} from "../../api/menu";

    const defaultForm = {
        name: null,
        title: null,
        path: null,
        component: null,
        redirect: null,
        icon: null,
        parent_id: null,
        order_num: null
    };
    export default {
        name: "MenuCreate",
        props: {
            'is-create': {
                type: Boolean,
                default: false
            },
            'parent-nodes': {
                type: Object,
                default: {}
            },
            title: {
                type: String,
                default: '添加操作'
            }
        },
        data() {
            return {
                form: Object.assign({}, defaultForm),
                show: this.isCreate,
                router_id: null,
                parents: this.parentNodes
            }
        },
        watch: {
            parentNodes(value){
                this.parents = value;
                this.form = Object.assign({}, defaultForm);
                this.form.parent_id = this.parents.id;
            },
            isCreate(value){
                this.show = value;
            }
        },
        methods: {
            checkForm() {
                if (this.form.parent_id.length == 0) {
                    this.$parent.alerts.push({'type': 'danger', 'msg': '请选择上级菜单', 'show': 10, 'down': 0});
                    return false
                }
                if (this.form.name.length == 0) {
                    this.$parent.alerts.push({'type': 'danger', 'msg': '请输入视图名称', 'show': 10, 'down': 0});
                    return false
                }
                if (this.form.title.length == 0) {
                    this.$parent.alerts.push({'type': 'danger', 'msg': '请输入菜单名称', 'show': 10, 'down': 0});
                    return false
                }
                if (this.form.component.length == 0) {
                    this.$parent.alerts.push({'type': 'danger', 'msg': '请输入视图路径', 'show': 10, 'down': 0});
                    return false
                }
                if (this.form.path.length == 0) {
                    this.$parent.alerts.push({'type': 'danger', 'msg': '请输入跳转地址', 'show': 10, 'down': 0});
                    return false
                }
                return true
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
                this.form = defaultForm;
                this.show = false;
                this.$parent.isCreate = false;
            }
        }
    }
</script>

<style scoped>

</style>
