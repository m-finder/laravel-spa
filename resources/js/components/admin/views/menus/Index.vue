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
                                     :contextMenuItems="menus" @nodeSelect="nodeSelect" :nodesDraggable="false"
                                     @contextMenuItemSelect="menuItemSelected" :renameNodeOnDblClick="false"/>
                    </div>
                </div>
            </div>
            <!--      资源列表      -->
            <div class="col-8">
                <transition name="fade" mode="out-in">
                    <elements :menu-id="form.id"/>
                </transition>
            </div>
        </div>

        <create :title="'添加菜单'" :is-create="isCreate" :parent-nodes="parentNodes"/>
        <edit :title="'编辑菜单'" :id="form.id" :isEdit="isEdit"/>
        <delete :title="'删除菜单'" :data="form" :is-delete="isDelete"/>
        <alert :alerts="alerts"/>
    </section>
</template>

<script>
    import {getAll, deleteData} from "../../api/menu";
    import Alert from '../../components/alert/Index';
    import {bTreeView} from 'bootstrap-vue-treeview';
    import Edit from './Edit';
    import Create from './Create';
    import Delete from '../../components/delete/Index';
    import Elements from '../elements/Index';

    const defaultForm = {
        id: null,
        name: null,
    };

    export default {
        name: "MenuList",
        components: {
            Alert,
            bTreeView,
            Create,
            Edit,
            Delete,
            Elements
        },
        data() {
            return {
                alerts: [],
                items: [],
                isEdit: false,
                isCreate: false,
                isDelete: false,
                parentNodes: {},
                menus: [{code: 'ADD_MENU', label: '添加子菜单'}, {code: 'RENAME_MENU',label: '编辑菜单'}, {code: 'DELETE_MENU', label: '删除菜单'}, ],
                form: Object.assign({}, defaultForm),
                node: null,
                loading: true,
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
                if (isSelected) {
                    this.form = Object.assign({}, node.data);
                } else if (node.data.id === this.form.id) {
                    this.form = Object.assign({}, defaultForm)
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
                            this.alerts.push({'type': 'danger', 'msg': '暂只支持二级菜单', 'show': 10, 'down': 0});
                        }
                        break;
                    case 'DELETE_MENU':
                        this.form.name = this.form.title;
                        this.isDelete = true;
                        break;
                    case 'RENAME_MENU':
                        this.isEdit = true;
                        break;
                    default:
                        break;
                }
            },
            getAll() {
                getAll().then(response => {
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
            deleteData() {
                deleteData(this.form.id).then((response) => {
                    this.alerts.push({'type': response.data.msg_type, 'msg': response.data.msg, 'show': 10, 'down': 0});
                    if (response.data.code == 0) {
                        this.node.delete();
                        this.isDelete = false;
                    }
                }).catch((error) => {
                    this.alerts.push({'type': 'danger', 'msg': '系统出错，请联系管理员查看', 'show': 10, 'down': 0});
                    console.log(error);
                });
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
