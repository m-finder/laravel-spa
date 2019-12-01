<template>
    <section class="content container-fluid">
        <div class="row justify-content-center p-3">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">角色列表</h3>
                    </div>

                    <div class="card-body">
                        <div class="card-tools mb-3">

                            <div class="btn-group  mr-3">
                                <form model="form">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">角色名</span>
                                                </div>
                                                <b-form-input type="text" v-model="form.name" placeholder="输入角色名"/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">角色别名</span>
                                                </div>
                                                <b-form-input type="text" v-model="form.alias"
                                                              placeholder="输入角色别名"/>
                                                <div class="input-group-append">
                                                    <button type="button" @click="getList()"
                                                            class="btn btn-primary">
                                                        <svg-vue icon="search"/>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="btn-group mr-3">
                                <b-button class="btn-sm" variant="primary" @click="openAddModal">添加角色</b-button>
                            </div>

                            <div class="btn-group">
                                <b-button class="btn-sm" variant="primary" @click="refresh">刷新列表</b-button>
                            </div>
                        </div>

                        <b-table hover :items="items" :fields="fields" :sort-by.sync="sortBy"
                                 :sort-desc.sync="sortDesc" :busy.sync="isBusy"
                                 responsive="sm" outlined ref="table" show-empty sticky-header>

                            <div slot="table-busy" class="text-center text-danger my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>

                            <template v-slot:cell(actions)="row">
                                <b-button v-if="row.item.id != 1" variant="link" class="text-danger mr-1"
                                          @click="openDeleteModal(row.item)">
                                    删除
                                </b-button>
                                <b-button variant="link" @click="openEditModal(row.item)">编辑</b-button>
                            </template>
                        </b-table>

                        <b-row>
                            <b-col md="6" class="my-1">
                                <b-pagination v-model="form.page" :total-rows="total" :per-page="form.limit"
                                              class="my-0"/>
                                <b-card-text class="mt-3 text-secondary">共 {{ total }} 条数据</b-card-text>
                            </b-col>
                        </b-row>
                    </div>
                </div>
            </div>
        </div>

        <b-modal centered id="modal-role-delete" title="删除角色">
            <p class="my-4">
                {{ deleteForm.name ? '是否确认删除角色 ' + deleteForm.name + '？' : '是否删除该角色？'}}
            </p>
            <div slot="modal-footer" class="w-100">
                <b-button variant="primary" size="sm" @click="cancel('modal-role-delete')">取消</b-button>
                <b-button variant="danger" size="sm" @click="deleteData">确认</b-button>
            </div>
        </b-modal>

        <b-modal centered id="modal-role-add" title="添加角色" @hidden="resetModal">
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">角色名称</span>
                    </div>
                    <input type="text" name="name" v-model="addForm.name"
                           class="form-control" placeholder="角色名称">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">角色别名</span>
                    </div>
                    <input type="text" name="alias"  v-model="addForm.alias"
                           class="form-control" placeholder="角色别名">
                </div>
            </div>
            <div slot="modal-footer" class="w-100">
                <b-button variant="primary" size="sm" @click="cancel('modal-role-add')">取消</b-button>
                <b-button variant="danger" size="sm" @click="submitAdd">提交</b-button>
            </div>
        </b-modal>

        <b-modal centered id="modal-role-edit" title="编辑角色" @hidden="resetModal">
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">角色名称</span>
                    </div>
                    <input type="text" name="name" v-model="editForm.name"
                           class="form-control" placeholder="角色名称">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">角色别名</span>
                    </div>
                    <input type="text" name="alias"  v-model="editForm.alias"
                           class="form-control" placeholder="角色别名">
                </div>
            </div>
            <div slot="modal-footer" class="w-100">
                <b-button variant="primary" size="sm" @click="cancel('modal-role-edit')">取消</b-button>
                <b-button variant="danger" size="sm" @click="submitEdit">提交</b-button>
            </div>
        </b-modal>

        <alert :alerts="alerts"/>

    </section>
</template>

<script>
    import {getData, deleteData, createData, updateData} from "../../api/role";
    import Alert from '../../components/alert/Index'

    const form = {
        name: null,
        alias: null,
        limit: 20,
        page: 1,
    };
    const addForm = {
        name:null,
        alias: null
    };
    const deleteForm = {
        id: null,
        name: null
    };

    export default {
        name: "RoleList",
        components: {
            Alert
        },
        data() {
            return {
                alerts: [],
                isBusy: true,
                total: 0,
                items: [],
                form: Object.assign({}, form),
                addForm: Object.assign({}, addForm),
                editForm: Object.assign({id: null}, addForm),
                deleteForm: Object.assign({}, deleteForm),
                sortBy: 'id',
                sortDesc: false,
                fields: [
                    {label: 'ID', key: 'id', sortable: true},
                    {label: '角色名', key: 'name', sortable: false},
                    {label: '角色别名', key: 'alias', sortable: false},
                    {label: '创建时间', key: 'created_at', sortable: true},
                    {label: '操作', key: 'actions', sortable: false}
                ]
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
            refresh(){
                this.form = Object.assign({}, form);
                this.getList()
            },
            getList() {
                this.isBusy = true;
                getData(this.form).then((response) => {
                    if(response.data.code == 0){
                        this.isBusy = false;
                        this.form.page = response.data.data.current_page;
                        this.items = response.data.data.data;
                        this.total = response.data.data.total;
                    }else{
                        this.alerts.push({'type': 'danger','msg': response.data.msg,'show': 10,'down': 0});
                        console.log(response);
                    }
                }).catch((error) => {
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error);
                });
            },
            openDeleteModal(data) {
                this.deleteForm = data;
                this.$root.$emit('bv::show::modal', 'modal-role-delete')
            },
            deleteData() {
                this.$bvModal.hide('modal-role-delete');
                deleteData(this.deleteForm.id).then((response) => {
                    this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0});
                    if (response.data.code == 0) {
                        this.items = this.items.filter(item => item.id != this.deleteForm.id);
                        this.total = this.total - 1;
                        this.deleteForm = Object.assign({}, deleteForm);
                    }
                }).catch((error) => {
                    this.alerts.push({'type': 'danger','msg': error.toString(),'show': 10,'down': 0});
                })
            },
            openAddModal() {
                this.$root.$emit('bv::show::modal', 'modal-role-add')
            },
            checkAddForm(){
                if(!this.addForm.name){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入角色名'});
                    return false;
                }
                if(!this.addForm.alias){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入角色别名'});
                    return false;
                }
                return true;
            },
            submitAdd(){
                if (this.checkAddForm()){
                    createData(this.addForm).then(response => {
                        this.alerts.push({'type': response.data.msg_type,'show': 10,'down': 0,'msg': response.data.msg});
                        if(response.data.code==0){
                            this.$bvModal.hide('modal-role-add');
                            this.getList()
                        }
                    }).catch(error => {
                        let error_message = error.response.data.message || error.message;
                        this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                        console.log(error_message)
                    })
                }
            },
            openEditModal(data) {
                this.editForm = data;
                this.$root.$emit('bv::show::modal', 'modal-role-edit')
            },
            checkEditForm(){
                if(!this.editForm.id){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '角色获取失败'});
                    return false;
                }
                if(!this.editForm.name){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入角色名'});
                    return false;
                }
                if(!this.editForm.alias){
                    this.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入角色别名'});
                    return false;
                }
                return true;
            },
            submitEdit(){
                if (this.checkEditForm()){
                    updateData(this.editForm).then(response => {
                        this.alerts.push({'type': response.data.msg_type,'show': 10,'down': 0,'msg': response.data.msg});
                        if(response.data.code==0){
                            this.$bvModal.hide('modal-role-edit');
                            this.getList()
                        }
                    }).catch(error => {
                        let error_message = error.response.data.message || error.message;
                        this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                        console.log(error_message)
                    })
                }
            },
            cancel(modal) {
                this.$bvModal.hide(modal)
            },
            resetModal() {
                this.addForm = Object.assign({}, addForm);
                this.editForm = Object.assign({id: null}, addForm);
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
</style>
