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
                                <b-button class="btn-sm" variant="primary">添加菜单</b-button>
                            </div>
                        </div>

                        <b-tree-view v-if="items && items.length" :data="items" :contextMenuItems="menus"
                                     @nodeSelect="nodeSelect" @contextMenuItemSelect="menuItemSelected" />
                    </div>
                </div>
            </div>
        </div>

        <b-modal centered id="modal-menu-delete" title="操作提醒" @hidden="resetModal">
            <p class="my-4">
                {{ name ? '是否确认删除菜单 ' + name + '？' : '是否删除该菜单？'}}
            </p>
            <div slot="modal-footer" class="w-100">
                <b-button variant="primary" size="sm" @click="cancel">取消</b-button>
                <b-button variant="danger" size="sm" @click="sure">确认</b-button>
            </div>
        </b-modal>

        <alert :alerts="alerts"/>

    </section>
</template>

<script>
    import {getAll, deleteData} from "../../api/menu";
    import Alert from '../../components/alert/Index'
    import { bTreeView } from 'bootstrap-vue-treeview'
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
                name: '',
                id: '',
                selectedNode: null,
                menus: [{code: 'ADD_MENU', label: '添加菜单'},{code: 'DELETE_MENU', label: '删除菜单'}, {code: 'RENAME_MENU', label: '重命名'}]
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
            nodeSelect(node, isSelected) {
                console.log('Node ' + node.data.name + ' has been ' + (isSelected ? 'selected' : 'deselected'))
                if (isSelected) {
                    this.name = node.data.name;
                    this.id = node.data.id;
                } else if (node.data === this.selectedNode) {
                    this.resetModal();
                }
            },
            menuItemSelected(item, node) {
                console.log(item)
                // if (item.code === 'ADD_CHILD_NODE') {
                //     node.appendChild({
                //         id: count++,
                //         name: 'My new node'
                //     })
                // }

                switch (item.code) {
                    case 'ADD_MENU':
                        console.log('添加菜单');
                        node.appendChild({id: count++,name: 'My new node'});
                        break;
                    case 'DELETE_MENU':
                        console.log('删除菜单');
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
            sure() {
                this.$bvModal.hide('modal-menu-delete')
                deleteData(this.id).then((response) => {
                    this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg, 'show': 10,'down': 0});
                    if (response.data.code == 0) {
                        this.items = this.items.filter(item => item.id != this.id)
                        this.total = this.total - 1
                    }
                }).catch((error)=>{
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error);
                });
            },
            cancel() {
                this.$bvModal.hide('modal-menu-delete')
            },
            resetModal() {
                this.name = '';
                this.form.id = null
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
