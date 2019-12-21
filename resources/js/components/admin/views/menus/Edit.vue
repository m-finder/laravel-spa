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
                        <option :value="0">顶级菜单</option>
                    </template>
                    <template v-if="form.id != 1 " v-for="(p, i) in parentNodes">
                        <option v-if="form.id != p.id" :selected="p.id==form.parent_id ? true : false" :value="p.id">
                            {{ p.title }}
                        </option>
                    </template>
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

        <div class="col-lg-12">
            <div class="col-lg-6">
                <div class="input-group mb-3">
                    <b-form-checkbox switch value="1" v-model="form.hidden">是否隐藏</b-form-checkbox>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-group mb-3">
                    <b-form-checkbox switch value="1" v-model="form.affix">常驻标题栏</b-form-checkbox>
                </div>
            </div>
        </div>

        <div slot="modal-footer" class="w-100">
            <b-button variant="primary" size="sm" @click="resetModal">取消</b-button>
            <b-button v-has="'menu:edit'" :disabled="disabled"  variant="danger" size="sm" @click="submitUpdate">确认</b-button>
        </div>
    </b-modal>
</template>

<script>
    import {getDetail, getParents, updateData} from "../../api/menu";

    const defaultForm = {
        id: null,
        name: null,
        title: null,
        path: null,
        component: null,
        redirect: null,
        icon: null,
        parent_id: null,
        order_num: null,
        hidden: 0,
        affix: 0
    };
    export default {
        name: "MenuEdit",
        props: {
            id: {
                default: null
            },
            isEdit: {
                type: Boolean,
                default: false
            },
            title: {
                type: String,
                default: '编辑操作'
            }
        },
        data() {
            return {
                form: Object.assign({}, defaultForm),
                parentNodes: [],
                show: this.isEdit,
                disabled: true,
                router_id: null
            }
        },
        watch: {
            isEdit(value){
                this.show = value;
                if(value){
                    this.disabled = true;
                    this.getDetail();
                    this.getParents();
                }
            }
        },
        methods: {
            getDetail() {
                getDetail(this.id).then(res => {
                    this.form = res.data;
                    this.disabled = false;
                })
            },
            getParents() {
                getParents().then(res => {
                    this.parentNodes = res.data;
                })
            },
            checkForm() {
                if (this.form.parent_id.length == 0) {
                    this.$toast.warning('请选择上级菜单', 'Warning');
                    return false
                }
                if (this.form.name.length == 0) {
                    this.$toast.warning('请输入视图名称', 'Warning');
                    return false
                }
                if (this.form.title.length == 0) {
                    this.$toast.warning('请输入菜单名称', 'Warning');
                    return false
                }
                if (this.form.component.length == 0) {
                    this.$toast.warning('请输入视图路径', 'Warning');
                    return false
                }
                if (this.form.path.length == 0) {
                    this.$toast.warning('请输入跳转地址', 'Warning');
                    return false
                }
                return true
            },
            submitUpdate() {
                if (this.checkForm()) {
                    updateData(this.form).then(res => {
                        this.$toast.success('编辑成功。', 'Success');
                        this.$parent.getAll();
                        this.resetModal()
                    })
                }
            },
            resetModal() {
                this.form = Object.assign({}, defaultForm);
                this.show = false;
                this.$parent.isEdit = false;
            }
        }
    }
</script>

<style scoped>

</style>
