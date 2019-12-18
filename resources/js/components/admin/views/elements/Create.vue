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
        menu_id: null,
        name: null,
        code: null,
        method: 'get',
        path: null,
    };
    export default {
        name: "ElementCreate",
        data() {
            return {
                form: Object.assign({}, defaultForm),
                show: false
            }
        },
        props: {
            'menu-id': {
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
        watch: {
            isCreate(value) {
                this.form.menu_id = this.menuId;
                this.show = value;
            }

        },
        methods: {
            checkForm() {
                if (!this.form.menu_id) {
                    this.$toast.warning('菜单数据获取失败，请重试', 'Warning');
                    return false;
                }
                if (!this.form.name) {
                    this.$toast.warning('请输入资源名称', 'Warning');
                    return false;
                }
                if (!this.form.code) {
                    this.$toast.warning('请输入资源编号', 'Warning');
                    return false;
                }
                if (!this.form.method) {
                    this.$toast.warning('请选择请求方法', 'Warning');
                    return false;
                }
                if (!this.form.path) {
                    this.$toast.warning('请输入请求路径', 'Warning');
                    return false;
                }
                return true;
            },
            submitCreate() {
                if (this.checkForm()) {
                    createData(this.form).then(res => {
                        this.$toast.success(res.msg, 'Success');
                        this.$parent.getList();
                        this.resetModal();
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