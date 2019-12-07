<template>
    <section class="content container-fluid">
        <div class="row justify-content-center p-3">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">用户列表</h3>
                    </div>
                    <div class="card-body">
                        <div class="card-tools mb-3">

                            <div class="btn-group mr-3">
                                <form model="form">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">用户名</span>
                                                </div>
                                                <b-form-input type="text" v-model="form.name" placeholder="输入用户名"/>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">邮箱</span>
                                                </div>
                                                <b-form-input type="email" v-model="form.email"
                                                              placeholder="输入用户邮箱"/>
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
                                <b-button class="btn-sm" variant="primary" @click="openAddModal">添加用户</b-button>
                            </div>

                            <div class="btn-group mr-3">
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

                            <template v-slot:cell(avatar)="data">
                                <img :src="getAvatar(data.value) " class="img-circle row-user-avatar" alt="用户头像">
                            </template>

                            <template v-slot:cell(role)="row">
                                {{ row.item.role.alias}}
                            </template>

                            <template v-slot:cell(actions)="row">
                                <b-button v-if="row.item.id != 1" variant="link" class="text-danger mr-1" @click="openDeleteModal(row.item)">
                                    删除
                                </b-button>
                                <b-button v-if="row.item.id != 1" variant="link" @click="openEditModal(row.item)">编辑</b-button>
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

        <b-modal centered id="modal-admin-delete" title="删除用户" @hidden="resetModal">
            <p class="my-4">
                {{ deleteForm.name ? '是否确认删除用户 ' + deleteForm.name + '？' : '是否删除该用户？'}}
            </p>
            <div slot="modal-footer" class="w-100">
                <b-button variant="primary" size="sm" @click="cancel('modal-admin-delete')">取消</b-button>
                <b-button variant="danger" size="sm" @click="deleteData">提交</b-button>
            </div>
        </b-modal>

<!--        <b-modal centered id="modal-admin-add" title="添加用户" @hidden="resetModal">-->
<!--            <div class="col-lg-12">-->
<!--                <div class="input-group mb-3">-->
<!--                    <div class="input-group-prepend">-->
<!--                        <span class="input-group-text">用户名称</span>-->
<!--                    </div>-->
<!--                    <input type="text" name="name" v-model="addForm.name"-->
<!--                           class="form-control" placeholder="角色名称">-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-12">-->
<!--                <div class="input-group mb-3">-->
<!--                    <div class="input-group-prepend">-->
<!--                        <span class="input-group-text">登录邮箱</span>-->
<!--                    </div>-->
<!--                    <input type="email" name="email"  v-model="addForm.email"-->
<!--                           class="form-control" placeholder="登录邮箱">-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-12">-->
<!--                <div class="input-group mb-3">-->
<!--                    <div class="input-group-prepend">-->
<!--                        <span class="input-group-text">登录密码</span>-->
<!--                    </div>-->
<!--                    <input type="password" name="password"  v-model="addForm.password" class="form-control" placeholder="登录密码">-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-12">-->
<!--                <div class="input-group mb-3">-->
<!--                    <div class="input-group-prepend">-->
<!--                        <span class="input-group-text">角色绑定</span>-->
<!--                    </div>-->
<!--                    <b-form-select v-model="addForm.role_id">-->
<!--                        <template v-slot:first>-->
<!--                            <option :value="null" disabled>&#45;&#45; 请选择角色进行绑定 &#45;&#45;</option>-->
<!--                        </template>-->
<!--                        <template v-for="(role, i) in roles">-->
<!--                            <option :value="role.id">{{role.alias}}</option>-->
<!--                        </template>-->
<!--                    </b-form-select>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div slot="modal-footer" class="w-100">-->
<!--                <b-button variant="primary" size="sm" @click="cancel('modal-admin-add')">取消</b-button>-->
<!--                <b-button variant="danger" size="sm" @click="submitAdd">确认</b-button>-->
<!--            </div>-->
<!--        </b-modal>-->

<!--        <b-modal centered id="modal-admin-edit" title="编辑用户" @hidden="resetModal">-->
<!--            <div class="col-lg-12">-->
<!--                <div class="input-group mb-3">-->
<!--                    <div class="input-group-prepend">-->
<!--                        <span class="input-group-text">用户名称</span>-->
<!--                    </div>-->
<!--                    <input type="text" name="name" v-model="editForm.name"-->
<!--                           class="form-control" placeholder="角色名称">-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-12">-->
<!--                <div class="input-group mb-3">-->
<!--                    <div class="input-group-prepend">-->
<!--                        <span class="input-group-text">登录邮箱</span>-->
<!--                    </div>-->
<!--                    <input type="email" name="email"  v-model="editForm.email"-->
<!--                           class="form-control" placeholder="登录邮箱">-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-12">-->
<!--                <div class="input-group mb-3">-->
<!--                    <div class="input-group-prepend">-->
<!--                        <span class="input-group-text">登录密码</span>-->
<!--                    </div>-->
<!--                    <input type="password" name="password"  v-model="editForm.password" class="form-control" placeholder="登录密码">-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="col-lg-12">-->
<!--                <div class="input-group mb-3">-->
<!--                    <div class="input-group-prepend">-->
<!--                        <span class="input-group-text">角色绑定</span>-->
<!--                    </div>-->
<!--                    <b-form-select v-model="editForm.role_id">-->
<!--                        <template v-slot:first>-->
<!--                            <option :value="null" disabled>&#45;&#45; 请选择角色进行绑定 &#45;&#45;</option>-->
<!--                        </template>-->
<!--                        <template v-for="(role, i) in roles">-->
<!--                            <option :selected="role.id == editForm.role_id" :value="role.id">{{role.alias}}</option>-->
<!--                        </template>-->
<!--                    </b-form-select>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div slot="modal-footer" class="w-100">-->
<!--                <b-button variant="primary" size="sm" @click="cancel('modal-admin-edit')">取消</b-button>-->
<!--                <b-button variant="danger" size="sm" @click="submitEdit">提交</b-button>-->
<!--            </div>-->
<!--        </b-modal>-->

        <create :title="'添加用户'" :is-create="isCreate"/>
        <edit :id="this.id" :title="'编辑用户'" :is-edit="isEdit"/>
        <alert :alerts="alerts"/>

    </section>
</template>

<script>
    import {getData, deleteData, createData, updateData, getDetail} from "../../api/admin";
    import Alert from '../../components/alert/Index';
    import Create from "./Create";
    import Edit from "./Edit";
    import {getAll} from "../../api/role";

    const deleteForm = {
        id: null,
        name: null
    };

    const form = {
        name: null,
        email: null,
        limit: 20,
        page: 1,
    };

    export default {
        name: "AdminList",
        components:{
            Alert,
            Create,
            Edit
        },
        data() {
            return {
                alerts: [],
                isBusy: true,
                isCreate: false,
                isEdit: false,
                total: 0,
                items: [],
                roles: [],
                id: null,
                deleteForm: Object.assign({}, deleteForm),
                form: Object.assign({}, form),
                sortBy: 'id',
                sortDesc: false,
                fields: [
                    {label: 'ID', key: 'id', sortable: true},
                    {label: '昵称', key: 'name', sortable: false},
                    {label: '角色', key: 'role', sortable: false},
                    {label: '邮箱', key: 'email', sortable: false},
                    {label: '头像', key: 'avatar', sortable: false},
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
                    this.isBusy = false;
                    this.currentPage = response.data.data.current_page;
                    this.items = response.data.data.data;
                    this.total = response.data.data.total;
                }).catch((error)=>{
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error);
                });
            },
            getAvatar(avatar) {
                return '/' + avatar;
            },
            openDeleteModal(data) {
                this.deleteForm = data;
                this.$root.$emit('bv::show::modal', 'modal-admin-delete')
            },
            deleteData() {
                this.$bvModal.hide('modal-admin-delete')
                deleteData(this.deleteForm.id).then((response) => {
                    this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg, 'show': 10,'down': 0});
                    if (response.data.code == 0) {
                        this.items = this.items.filter(item => item.id != this.deleteForm.id);
                        this.total = this.total - 1;
                        this.deleteForm = Object.assign({}, deleteForm);
                    }
                }).catch((error)=>{
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error);
                });
            },
            openAddModal(){
                this.isCreate = true;
            },
            getRole(){
                getAll().then(response => {
                    if(response.data.code == 0){
                        this.roles = response.data.data;
                    }else{
                        this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0});
                    }
                }).catch(error => {
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0 });
                    console.log(error);
                })
            },
            openEditModal(data){
                this.id = data.id;
                this.isEdit = true;
            },
            cancel(modal) {
                this.$bvModal.hide(modal)
            },
            resetModal() {

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
