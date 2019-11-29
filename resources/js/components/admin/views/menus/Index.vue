<template>
    <section class="content container-fluid">
        <div class="row justify-content-center p-3">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">菜单列表</h3>
                    </div>
                    <div class="card-body">
                        <div class="card-tools mb-3">
                            <div class="btn-group mr-3">
                                <b-button class="btn-sm" variant="primary" @click="addMenu">添加菜单</b-button>
                            </div>
                        </div>

                        <b-tree-view v-if="items && items.length" :data="items" :contextMenuItems="menus"
                                     @nodeSelect="nodeSelect" @contextMenuItemSelect="menuItemSelected" />
                    </div>
                </div>
            </div>
        </div>

        <b-modal centered id="modal-menu-delete" title="操作提醒" @hidden="resetModal('form', 'defaultForm')">
            <p class="my-4">
                {{ form.name ? '是否确认删除菜单 ' + form.name + '？' : '是否删除该菜单？'}}
            </p>
            <div slot="modal-footer" class="w-100">
                <b-button variant="primary" size="sm" @click="cancel('modal-menu-delete')">取消</b-button>
                <b-button variant="danger" size="sm" @click="deleteData">确认</b-button>
            </div>
        </b-modal>

        <b-modal centered id="modal-menu-add" title="操作提醒" @hidden="resetModal('form', 'defaultForm')">
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">菜单名称</span>
                    </div>
                    <b-form-input v-model="form.name" placeholder="请输入菜单名称" required />
                </div>
            </div>
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">上级菜单</span>
                    </div>
                    <b-form-select v-model="form.parent_id">
                        <template v-slot:first>
                            <option :value="null" disabled>-- 请选择上级菜单 --</option>
                        </template>
                        <template v-for="(p, i) in parentNodes">
                            <option :value="p.id">{{ p.name }}</option>
                        </template>
                    </b-form-select>
                </div>
            </div>

            <div slot="modal-footer" class="w-100">
                <b-button variant="primary" size="sm" @click="cancel('modal-menu-add')">取消</b-button>
                <b-button variant="danger" size="sm" @click="submitAdd">确认</b-button>
            </div>
        </b-modal>

        <alert :alerts="alerts"/>

    </section>
</template>

<script>
    import {getAll, deleteData} from "../../api/menu";
    import Alert from '../../components/alert/Index'
    import { bTreeView } from 'bootstrap-vue-treeview'

    const defaultForm = {
        id: null,
        name: null,
        parent_id: null,
    };
    export default {
        name: "MenuList",
        components:{
            Alert,
            bTreeView
        },
        data() {
            return {
                alerts: [],
                items: [],
                parentNodes: [],
                selectedNode: null,
                menus: [{code: 'ADD_MENU', label: '添加子菜单'},{code: 'DELETE_MENU', label: '删除菜单'}, {code: 'RENAME_MENU', label: '重命名'}],
                form:  Object.assign({}, defaultForm),
            }
        },
        created() {
            this.getList()
        },
        watch: {
            'form.page'() {
                this.getList()
            },
        },
        methods: {
            submitAdd(){
                console.log(this.form)
            },
            addMenu(){
                this.parentNodes = [{id: 0, name: '顶级菜单'}];
                this.form = Object.assign({}, defaultForm);
                this.form.parent_id = 0;
                this.$root.$emit('bv::show::modal', 'modal-menu-add');
            },
            nodeSelect(node, isSelected) {
                if (isSelected) {
                    this.form = Object.assign({}, node.data);
                    console.log(this.form)
                }
            },
            menuItemSelected(item, node) {
                switch (item.code) {
                    case 'ADD_MENU':
                        let id = this.form.id;
                        this.parentNodes = [{id: id, name: this.form.name}];
                        this.form = Object.assign({}, defaultForm);
                        this.form.parent_id = id;
                        this.$root.$emit('bv::show::modal', 'modal-menu-add');
                        // node.appendChild({id: count++,name: 'My new node'});
                        break;
                    case 'DELETE_MENU':
                        this.$root.$emit('bv::show::modal', 'modal-menu-delete');
                        break;
                    case 'RENAME_MENU':
                        console.log('重命名');
                        break;
                    default: break;
                }
            },
            getList() {
                this.isBusy = true;
                getAll(this.form).then((response) => {
                    this.isBusy = false;
                    this.items = response.data.data;
                    this.total = response.data.data.length;
                }).catch((error)=>{
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error);
                });
            },
            openDeleteModal(data) {
                this.name = data.name;
                this.id = data.id;
                this.$root.$emit('bv::show::modal', 'modal-menu-delete')
            },
            deleteData() {
                this.$bvModal.hide('modal-menu-delete');
                deleteData(this.form.id).then((response) => {
                    this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg, 'show': 10,'down': 0});
                    if (response.data.code == 0) {
                        this.items = this.items.filter(item => item.id != this.form.id)
                        this.total = this.total - 1
                    }
                }).catch((error)=>{
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error);
                });
            },
            cancel(modal) {
                this.$bvModal.hide(modal)
            },
            resetModal(form, defaultForm) {
                this[form] = defaultForm
            }
        }
    }
</script>

<style lang="scss" scoped>

    .row-user-avatar {
        width: 25px;
        height: 25px;
    }

    .btn, .btn-outline-info {
        svg{
            fill: #ffffff;
        }
    }
    .btn-outline-info{
        &:hover{
            color: #ffffff;
        }
    }
</style>
