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

                        <b-tree-view v-if="items && items.length" :data="items" :contextMenuItems="menus"
                                     @nodeSelect="nodeSelect" @contextMenuItemSelect="menuItemSelected"/>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">资源列表</h3>
                    </div>
                    <div class="card-body">
                        <div class="card-tools mb-3">
                            <div class="btn-group mr-3">
                                <b-button class="btn-sm" variant="primary" @click="addMenu">添加资源</b-button>
                            </div>
                        </div>

                        <b-table hover responsive="sm" outlined ref="table" show-empty sticky-header>

                           <tr>
                               <td>2222</td>
                           </tr>
                        </b-table>

                        <b-row>
                            <b-col md="6" class="my-1">
                               分页111222
                            </b-col>
                        </b-row>
                    </div>
                </div>
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

        <!--   添加子菜单     -->
        <b-modal centered id="modal-menu-add" title="添加菜单" @hidden="resetModal">
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">菜单名称</span>
                    </div>
                    <b-form-input v-model="form.name" placeholder="请输入菜单名称" required/>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">跳转地址</span>
                    </div>
                    <b-form-input v-model="form.url" placeholder="请输入跳转地址" required/>
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

        <!--    编辑菜单    -->
        <b-modal centered id="modal-menu-edit" title="编辑菜单">
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">菜单名称</span>
                    </div>
                    <b-form-input v-model="form.name" placeholder="请输入菜单名称" required/>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">跳转地址</span>
                    </div>
                    <b-form-input v-model="form.url" placeholder="请输入跳转地址" required/>
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
                        <span class="input-group-text">上级菜单</span>
                    </div>
                    <b-form-select v-model="form.parent_id">
                        <template v-slot:first>
                            <option :value="null" disabled>-- 请选择上级菜单 --</option>
                            <option :value="0" >顶级菜单</option>
                        </template>
                        <template v-if="form.id != 1 " v-for="(p, i) in parentNodes">
                            <option :disabled="form.parent_id==0?true:false" v-if="form.id != p.id" :selected="p.id==form.parent_id ? true : false" :value="p.id">{{ p.name }}</option>
                        </template>
                    </b-form-select>
                </div>
            </div>

            <div slot="modal-footer" class="w-100">
                <b-button variant="primary" size="sm" @click="cancel('modal-menu-edit')">取消</b-button>
                <b-button variant="danger" size="sm" @click="submitUpdate">确认</b-button>
            </div>
        </b-modal>


        <alert :alerts="alerts"/>

    </section>
</template>

<script>
    import {getAll, deleteData, createData, getParents, updateData} from "../../api/menu";
    import Alert from '../../components/alert/Index'
    import { bTreeView } from 'bootstrap-vue-treeview'

    const defaultForm = {
        id: null,
        name: null,
        url: null,
        icon: null,
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
                menus: [{code: 'ADD_MENU', label: '添加子菜单'},{code: 'DELETE_MENU', label: '删除菜单'}, {code: 'RENAME_MENU', label: '编辑菜单'}],
                form:  Object.assign({}, defaultForm),
                node: null,
            }
        },
        created() {
            this.getList()
        },
        methods: {
            addMenu(){
                this.parentNodes = [{id: 0, name: '顶级菜单'}];
                this.form = Object.assign({}, defaultForm);
                this.form.parent_id = 0;
                this.$root.$emit('bv::show::modal', 'modal-menu-add');
            },
            nodeSelect(node, isSelected) {
                if (isSelected) {
                    this.form = Object.assign({}, node.data);
                }
            },
            menuItemSelected(item, node) {
                this.node = node;
                switch (item.code) {
                    case 'ADD_MENU':
                        let id = this.form.id;
                        if(this.form.parent_id == 0){
                            this.parentNodes = [{id: id, name: this.form.name}];
                            this.form = Object.assign({}, defaultForm);
                            this.form.parent_id = id;
                            this.$root.$emit('bv::show::modal', 'modal-menu-add');
                        }else{
                            this.alerts.push({'type': 'danger','msg': '只支持二级菜单','show': 10,'down': 0});
                        }
                        break;
                    case 'DELETE_MENU':
                        this.$root.$emit('bv::show::modal', 'modal-menu-delete');
                        break;
                    case 'RENAME_MENU':
                        this.$root.$emit('bv::show::modal', 'modal-menu-edit');
                        this.getParents();
                        break;
                    default: break;
                }
            },
            getList() {
                getAll(this.form).then(response => {
                    this.items = response.data.data;
                }).catch(error =>{
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error);
                });
            },
            getParents() {
                getParents().then(response => {
                    this.parentNodes = response.data.data;
                }).catch(error =>{
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error);
                });
            },
            checkForm(){
                if(this.form.parent_id.length == 0){
                    this.alerts.push({'type': 'danger','msg': '请选择上级菜单','show': 10,'down': 0});
                    return false
                }
                if(this.form.name.length == 0){
                    this.alerts.push({'type': 'danger','msg': '请输入菜单名称','show': 10,'down': 0});
                    return false
                }
                if(this.form.url.length == 0){
                    this.alerts.push({'type': 'danger','msg': '请输入跳转地址','show': 10,'down': 0});
                    return false
                }
                return true
            },
            submitAdd(){
                if (this.checkForm()){
                    createData(this.form).then(response => {
                        this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0});
                        if(response.data.code==0){
                            this.$bvModal.hide('modal-menu-add');
                            let id = response.data.data.id, name = response.data.data.name;
                            if(this.form.parent_id == 0){
                                this.items.push({id: id, name: name})
                            }else{
                                this.node.appendChild({id: id, name: name});
                            }
                        }
                    }).catch((error) => {
                        this.alerts.push({'type': 'danger','msg': error.toString(),'show': 10,'down': 0});
                        console.log(error)
                    })
                }
            },
            submitUpdate(){
                if (this.checkForm()){
                    updateData(this.form).then(response => {
                        this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0});
                        if(response.data.code==0){
                            this.$bvModal.hide('modal-menu-edit');
                            this.getList()
                        }
                    }).catch((error) => {
                        this.alerts.push({'type': 'danger','msg': error.toString(),'show': 10,'down': 0});
                        console.log(error)
                    })
                }
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
                        this.$bvModal.hide('modal-menu-delete');
                        this.node.delete();
                    }
                }).catch((error)=>{
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error);
                });
            },
            cancel(modal) {
                this.$bvModal.hide(modal)
            },
            resetModal() {
                this.form = defaultForm
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
