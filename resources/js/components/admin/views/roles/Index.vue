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

                            <div class="btn-group">
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
                                <b-button class="btn-sm" variant="primary">添加角色</b-button>
                            </div>
                        </div>

                        <b-table striped hover :items="items" :fields="fields" :sort-by.sync="sortBy"
                                 :sort-desc.sync="sortDesc" :busy.sync="isBusy" :current-page="currentPage"
                                 :per-page="perPage" responsive="sm" outlined ref="table" show-empty
                                 sticky-header head-variant="light">

                            <div slot="table-busy" class="text-center text-danger my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Loading...</strong>
                            </div>

                            <template v-slot:cell(actions)="row">
                                <b-button v-if="row.item.id != 1" variant="link" class="text-danger mr-1" @click="openDeleteModal(row.item)">
                                    删除
                                </b-button>
                                <b-button variant="link" :href="'admins/edit' + row.item.id">编辑</b-button>
                            </template>
                        </b-table>

                        <b-row>
                            <b-col md="6" class="my-1">
                                <b-pagination v-model="currentPage" :total-rows="total" :per-page="perPage" class="my-0"/>
                                <b-card-text class="mt-3 text-secondary">共 {{ total }} 条数据</b-card-text>
                            </b-col>
                        </b-row>
                    </div>
                </div>
            </div>
        </div>

        <b-modal centered id="modal-admin-delete" title="操作提醒" @hidden="resetModal">
            <p class="my-4">
                {{ name ? '是否确认删除用户 ' + name + '？' : '是否删除该用户？'}}
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
    import {getData, deleteData} from "../../../../api/role";
    import Alert from '../../components/alert/Index'
    export default {
        name: "Index",
        components:{
            Alert
        },
        data() {
            return {
                alerts: [],
                isBusy: true,
                perPage: 3,
                currentPage: 1,
                total: 0,
                items: [],
                name: '',
                id: '',
                form: {
                    name: null,
                    alias: null,
                },
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
        methods: {
            getList() {
                this.isBusy = true;
                getData(this.form).then((response) => {
                    this.isBusy = false;
                    this.currentPage = response.data.data.current_page;
                    this.items = response.data.data.data;
                    this.total = response.data.data.total;
                }).catch((error)=>{
                    this.alerts.push({
                        'type': 'danger',
                        'msg': '系统出错，请联系管理员查看',
                        'show': 10,
                        'down': 0
                    });
                    console.log(error);
                });
            },
            getAvatar(avatar) {
                return '/' + avatar;
            },
            openDeleteModal(data) {
                this.name = data.name;
                this.id = data.id;
                this.$root.$emit('bv::show::modal', 'modal-admin-delete')
            },
            sure() {
                this.$bvModal.hide('modal-admin-delete')
                deleteData(this.id).then((response) => {
                    this.alerts.push({
                        'type': response.data.msg_type,
                        'msg': response.data.msg,
                        'show': 10,
                        'down': 0
                    });
                    if (response.data.code == 0) {
                        this.items = this.items.filter(item => item.id != this.id)
                        this.total = this.total - 1
                    }

                }).catch((error) => {
                    this.alerts.push({
                        'type': 'danger',
                        'msg': error.toString(),
                        'show': 10,
                        'down': 0
                    });
                })
            },
            cancel() {
                this.$bvModal.hide('modal-admin-delete')
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
