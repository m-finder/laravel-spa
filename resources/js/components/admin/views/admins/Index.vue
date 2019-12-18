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

                        <data-table :is-busy="isBusy" :items="items" :fields="fields" :notice="notice" :total="total" :limit="form.limit" :page="form.page">
                            <template v-slot:cell(avatar)="data">
                                <img :src="getAvatar(data.value) " class="img-circle row-user-avatar" alt="用户头像">
                            </template>

                            <template v-slot:cell(role)="row">
                                {{ row.item.role.alias}}
                            </template>

                            <template v-slot:cell(actions)="row">
                                <b-button v-if="row.item.id != 1" variant="link" @click="openEditModal(row.item)">编辑</b-button>
                                <b-button v-if="row.item.id != 1" variant="link" class="text-danger mr-1" @click="openDeleteModal(row.item)">删除</b-button>
                            </template>
                        </data-table>
                    </div>
                </div>
            </div>
        </div>

        <create :title="'添加用户'" :is-create="isCreate"/>
        <edit :id="selectForm.id" :title="'编辑用户'" :is-edit="isEdit"/>
        <delete :title="'删除用户'" :data="selectForm" :is-delete="isDelete"/>
    </section>
</template>

<script>
    import {getData, deleteData} from "../../api/admin";
    import Create from "./Create";
    import Edit from "./Edit";
    import Delete from '../../components/delete';
    import DataTable from '../../components/table'

    const defaultForm = {
        id: null,
        name: null,
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
            DataTable,
            Create,
            Edit,
            Delete
        },
        data() {
            return {
                isBusy: true,
                isCreate: false,
                isEdit: false,
                isDelete: false,
                total: 0,
                items: [],
                notice: '暂无数据',
                selectForm: Object.assign({}, defaultForm),
                form: Object.assign({}, form),
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
            'form.page'(value) {
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
                getData(this.form).then(res => {
                    this.isBusy = false;
                    this.currentPage = res.data.current_page;
                    this.items = res.data.data;
                    this.total = res.data.total;
                }).catch(error=>{
                    this.isBusy = false;
                    this.notice = (error.response.data.message) || '系统出错';
                });
            },
            getAvatar(avatar) {
                return '/' + avatar;
            },
            openDeleteModal(data) {
                this.selectForm = data;
                this.isDelete = true;
            },
            deleteData() {
                let id = this.selectForm.id;
                deleteData(id).then(res => {
                    this.$toast.success(res.msg, 'Success');
                    this.items = this.items.filter(item => item.id != id);
                    this.total = this.total - 1;
                    this.isDelete = false;
                })
            },
            openAddModal(){
                this.isCreate = true;
            },
            openEditModal(data){
                this.selectForm.id = data.id;
                this.isEdit = true;
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
