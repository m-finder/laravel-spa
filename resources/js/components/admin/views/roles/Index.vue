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

                        <b-table hover :items="items" :fields="fields" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" :busy.sync="isBusy" responsive="sm" outlined ref="table" show-empty sticky-header>
                            <div slot="table-busy" class="text-center text-danger my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>
                            <template v-slot:empty="scope">
                                <div class="text-center text-secondary">
                                    <p>
                                        <svg-vue icon="null" class="empty-data"/>
                                    </p>
                                    <h6>暂无数据</h6>
                                </div>
                            </template>
                            <template v-slot:cell(actions)="row">
                                <b-button v-if="row.item.id != 1" variant="link" @click="openEditModal(row.item)">编辑</b-button>
                                <b-button variant="link" class="text-danger" @click="assign(row.item)">权限分配</b-button>
                                <b-button v-if="row.item.id != 1" variant="link" class="text-danger" @click="openDeleteModal(row.item)">
                                    删除
                                </b-button>
                            </template>
                        </b-table>

                        <b-row>
                            <b-col md="6" class="my-1">
                                <b-pagination v-model="form.page" :total-rows="total" :per-page="form.limit" class="my-0"/>
                                <b-card-text class="mt-3 text-secondary">共 {{ total }} 条数据</b-card-text>
                            </b-col>
                        </b-row>
                    </div>
                </div>
            </div>
        </div>

        <create :title="'添加角色'" :is-create="isCreate"/>
        <edit :title="'编辑角色'" :id="selectForm.id" :is-edit="isEdit"/>
        <delete :title="'删除角色'" :data="selectForm" :is-delete="isDelete"/>
        <assign :title="'权限分配'" :id="selectForm.id" :is-assign="isAssign"/>
        <alert :alerts="alerts"/>
    </section>
</template>

<script>
    import {getData, deleteData} from "../../api/role";
    import Alert from '../../components/alert/Index';
    import Create from './Create';
    import Edit from './Edit';
    import Delete from '../../components/delete/Index';
    import Assign from '../roles-permissions/Index';

    const form = {
        name: null,
        alias: null,
        limit: 20,
        page: 1,
    };

    const defaultForm = {
        id: null,
        name: null,
    };

    export default {
        name: "RoleList",
        components: {
            Alert,
            Create,
            Edit,
            Delete,
            Assign
        },
        data() {
            return {
                alerts: [],
                isBusy: true,
                isCreate: false,
                isEdit: false,
                isDelete: false,
                isAssign: false,
                total: 0,
                items: [],
                form: Object.assign({}, form),
                selectForm: Object.assign({}, defaultForm),
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
            assign(data){
                this.selectForm = data;
                this.isAssign = true;
            },
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
                    }
                }).catch((error) => {
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error);
                });
            },
            openEditModal(data){
              this.selectForm.id = data.id;
              this.isEdit = true;
            },
            openAddModal(){
                this.isCreate = true
            },
            openDeleteModal(data) {
                this.selectForm = data;
                this.isDelete = true;
            },
            deleteData() {
                let id = this.selectForm.id;
                deleteData(id).then((response) => {
                    this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0});
                    if (response.data.code == 0) {
                        this.items = this.items.filter(item => item.id != id);
                        this.total = this.total - 1;
                        this.isDelete = false;
                    }
                }).catch((error) => {
                    this.alerts.push({'type': 'danger','msg': error.toString(),'show': 10,'down': 0});
                })
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
