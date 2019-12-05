<template>
    <section class="content container-fluid">
        <div class="row justify-content-center p-3">

            <div class="col-4">
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

                        <div v-if="loading" class="text-center text-danger my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Loading...</strong>
                        </div>

                        <b-tree-view v-if="items && items.length" :nodeLabelProp="'title'" :data="items"
                                     :contextMenuItems="menus" @nodeSelect="nodeSelect"
                                     @contextMenuItemSelect="menuItemSelected"/>
                    </div>
                </div>
            </div>

            <div class="col-8">
                <transition name="fade" mode="out-in">
                    <div class="card card-primary card-outline" v-if="elementForm.router_id">
                        <div class="card-header">
                            <h3 class="card-title mb-0">资源列表</h3>
                        </div>
                        <div class="card-body">
                            <div class="card-tools mb-3">
                                <div class="btn-group mr-3">
                                    <b-button class="btn-sm" variant="primary" @click="addMenu">添加资源</b-button>
                                </div>
                            </div>

                            <b-table hover :items="elements" :fields="fields" :sort-by.sync="sortBy"
                                     :sort-desc.sync="sortDesc" :busy.sync="isBusy"
                                     responsive="sm" outlined ref="table" show-empty>

                                <div slot="table-busy" class="text-center text-danger my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Loading...</strong>
                                </div>

                                <template v-slot:cell(actions)="row">
                                    <b-button variant="link" class="text-danger mr-1" @click="openDeleteModal(row.item)">
                                        删除
                                    </b-button>
                                    <b-button variant="link" @click="openEditModal(row.item)">编辑</b-button>
                                </template>
                            </b-table>

                            <b-row>
                                <b-col md="6" class="my-1">
                                    <b-pagination v-model="elementForm.page" :total-rows="total"
                                                  :per-page="elementForm.limit" class="my-0"/>
                                    <b-card-text class="mt-3 text-secondary">共 {{ total }} 条数据</b-card-text>
                                </b-col>
                            </b-row>
                        </div>
                    </div>
                </transition>
            </div>
        </div>

        <!--   删除菜单     -->
        <b-modal centered id="modal-menu-delete" title="删除菜单" @hidden="resetModal">
            <p class="my-4">
                {{ form.name ? '是否确认删除菜单 ' + form.name + '？' : '是否删除该菜单？'}}
            </p>
            <div slot="modal-footer" class="w-100">
                <b-button variant="primary" size="sm" @click="cancel('modal-menu-delete')">取消</b-button>
                <b-button variant="danger" size="sm" @click="deleteData">确认</b-button>
            </div>
        </b-modal>
        <!--    添加菜单    -->
        <create :title="'添加菜单'" :is-create="isCreate" :parent-nodes="parentNodes"/>
        <!--    编辑菜单    -->
        <edit :title="'编辑菜单'" :id="this.form.id" :isEdit="isEdit"/>
        <alert :alerts="alerts"/>
    </section>
</template>

<script>
    import {getAll, deleteData, createData, getParents} from "../../api/menu";
    import {getElement} from "../../api/menu";
    import Alert from '../../components/alert/Index'
    import {bTreeView} from 'bootstrap-vue-treeview'
    import Edit from './Edit'
    import Create from './Create'

    const defaultForm = {
        id: null,
        name: null,
        title: null,
        path: null,
        component: null,
        redirect: null,
        icon: null,
        parent_id: null,
        order: null
    };
    const defaultElementForm = {
        router_id: null,
        page: 1,
        limit: 20,
    };
    export default {
        name: "MenuList",
        components: {
            Alert,
            bTreeView,
            Create,
            Edit
        },
        data() {
            return {
                alerts: [],
                items: [],
                elements: [],
                total: 0,
                isEdit: false,
                isCreate: false,
                parentNodes: {},
                menus: [{code: 'ADD_MENU', label: '添加子菜单'}, {code: 'RENAME_MENU',label: '编辑菜单'}, {code: 'DELETE_MENU', label: '删除菜单'}, ],
                form: Object.assign({}, defaultForm),
                elementForm: Object.assign({}, defaultElementForm),
                node: null,
                loading: true,
                isBusy: true,
                sortBy: 'id',
                sortDesc: false,
                fields: [
                    {label: 'ID', key: 'id', sortable: true},
                    {label: '资源名称', key: 'name', sortable: false},
                    {label: '资源编号', key: 'code', sortable: false},
                    {label: '请求方法', key: 'method', sortable: false},
                    {label: '请求路径', key: 'path', sortable: false},
                    {label: '创建时间', key: 'created_at', sortable: true},
                    {label: '操作', key: 'actions', sortable: false}
                ]
            }
        },
        created() {
            this.getAll()
        },
        methods: {
            addMenu() {
                this.parentNodes = {id: 0, title: '顶级菜单'};
                this.isCreate = true;
            },
            nodeSelect(node, isSelected) {
                this.elementForm = Object.assign({}, defaultElementForm);
                if (isSelected) {
                    this.form = Object.assign({}, node.data);
                    this.elementForm.router_id = this.form.id;
                    this.isBusy = true;
                    this.getElement();
                }
            },
            menuItemSelected(item, node) {
                this.node = node;
                switch (item.code) {
                    case 'ADD_MENU':
                        let id = this.form.id;
                        if (this.form.parent_id == 0) {
                            this.parentNodes = {id: id, title: this.form.title};
                            this.isCreate = true;
                        } else {
                            this.alerts.push({'type': 'danger', 'msg': '只支持二级菜单', 'show': 10, 'down': 0});
                        }
                        break;
                    case 'DELETE_MENU':
                        this.$root.$emit('bv::show::modal', 'modal-menu-delete');
                        break;
                    case 'RENAME_MENU':
                        this.isEdit = true;
                        break;
                    default:
                        break;
                }
            },
            getAll() {
                getAll(this.form).then(response => {
                    if (response.data.code == 0) {
                        this.loading = false;
                        this.items = response.data.data;
                    } else {
                        this.alerts.push({'type': 'danger', 'msg': response.data.msg, 'show': 10, 'down': 0});
                        console.log(response);
                    }
                }).catch(error => {
                    this.alerts.push({'type': 'danger', 'msg': '系统出错，请联系管理员查看', 'show': 10, 'down': 0});
                    console.log(error);
                });
            },
            getElement() {
                getElement(this.elementForm).then(response => {
                    if (response.data.code == 0) {
                        this.isBusy = false;
                        this.elements = response.data.data.data;
                        this.elementForm.page = response.data.data.current_page;
                        this.total = response.data.data.total;
                    } else {
                        this.alerts.push({'type': 'danger', 'msg': response.data.msg, 'show': 10, 'down': 0});
                        console.log(response);
                    }
                }).catch(error => {
                    this.alerts.push({'type': 'danger', 'msg': '系统出错，请联系管理员查看', 'show': 10, 'down': 0});
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
                    this.alerts.push({'type': response.data.msg_type, 'msg': response.data.msg, 'show': 10, 'down': 0});
                    if (response.data.code == 0) {
                        this.$bvModal.hide('modal-menu-delete');
                        this.node.delete();
                    }
                }).catch((error) => {
                    this.alerts.push({'type': 'danger', 'msg': '系统出错，请联系管理员查看', 'show': 10, 'down': 0});
                    console.log(error);
                });
            },
            cancel(modal) {
                this.$bvModal.hide(modal)
            },
            resetModal() {
                this.form = Object.assign({}, defaultForm)
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
        svg {
            fill: #ffffff;
        }
    }

    .btn-outline-info {
        &:hover {
            color: #ffffff;
        }
    }
    .fade-enter-active, .fade-leave-active {
        transition-duration: 0.3s;
        transition-property: opacity;
        transition-timing-function: ease;
    }

    .fade-enter, .fade-leave-active {
        opacity: 0
    }
</style>
