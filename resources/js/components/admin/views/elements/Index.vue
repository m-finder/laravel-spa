<template>
    <div class="card card-primary card-outline" v-if="routerId">
        <div class="card-header">
            <h3 class="card-title mb-0">资源列表</h3>
        </div>
        <div class="card-body">
            <div class="card-tools mb-3">
                <div class="btn-group mr-3">
                    <b-button class="btn-sm" variant="primary" @click="addElement">添加资源</b-button>
                </div>
            </div>

            <b-table hover :items="items" :fields="fields" :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc" :busy.sync="isBusy"
                     responsive="sm" outlined ref="table" show-empty>

                <template v-slot:empty="scope">
                    <div class="text-center text-secondary">
                        <p>
                            <svg-vue icon="null" class="empty-data"/>
                        </p>
                        <h6>暂无数据</h6>
                    </div>
                </template>

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
                    <b-pagination v-model="form.page" :total-rows="total"
                                  :per-page="form.limit" class="my-0"/>
                    <b-card-text class="mt-3 text-secondary">共 {{ total }} 条数据</b-card-text>
                </b-col>
            </b-row>
        </div>

        <create :title="'添加资源'" :router-id="routerId" :is-create="isCreate"/>
        <edit :title="'编辑资源'" :id="form.id" :is-edit="isEdit"/>

        <b-modal centered id="modal-element-delete" title="删除资源" @hidden="resetModal">
            <p class="my-4">
                {{ deleteForm.name ? '是否确认删除资源 ' + deleteForm.name + '？' : '是否删除该资源？'}}
            </p>
            <div slot="modal-footer" class="w-100">
                <b-button variant="primary" size="sm" @click="resetModal">取消</b-button>
                <b-button variant="danger" size="sm" @click="deleteData">提交</b-button>
            </div>
        </b-modal>

        <!--    弹窗提醒    -->
        <alert :alerts="alerts"/>
    </div>
</template>

<script>
    import {getData, deleteData} from "../../api/element";
    import Alert from '../../components/alert/Index'
    import Create from './Create'
    import Edit from './Edit'

    const defaultForm = {
        router_id: null,
        page: 1,
        limit: 20,
    };

    const deleteForm = {
        id: null,
        name: null
    };

    export default {
        name: "ElementList",
        components: {
            Alert,
            Create,
            Edit
        },
        data(){
            return {
                alerts: [],
                items: [],
                total: 0,
                isBusy: true,
                isCreate: false,
                isEdit: false,
                sortBy: 'id',
                sortDesc: false,
                form: Object.assign({}, defaultForm),
                deleteForm: Object.assign({}, deleteForm),
                fields: [
                    {label: 'ID', key: 'id', sortable: true},
                    {label: '资源名称', key: 'name', sortable: false},
                    {label: '资源编号', key: 'code', sortable: false},
                    {label: '请求方法', key: 'method', sortable: false},
                    {label: '请求路径', key: 'path', sortable: false},
                    {label: '创建时间', key: 'created_at', sortable: true},
                    {label: '操作', key: 'actions', sortable: false}
                ],
            }
        },
        props:{
            'router-id': {
                default: null
            }
        },
        watch:{
            routerId(value){
                this.form.router_id = value;
                if(value){
                    this.isBusy = true;
                    this.getList()
                }
            }
        },
        methods: {
            getList() {
                getData(this.form).then(response => {
                    if (response.data.code == 0) {
                        this.isBusy = false;
                        this.items = response.data.data.data;
                        this.form.page = response.data.data.current_page;
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
            openDeleteModal(data){
                this.deleteForm = data;
                this.$root.$emit('bv::show::modal', 'modal-element-delete')
            },
            openEditModal(data){
                this.isEdit = true;
                this.form.id = data.id;
            },
            addElement(){
                this.isCreate = true
            },
            deleteData() {
                let id = this.deleteForm.id;
                this.$bvModal.hide('modal-element-delete');
                deleteData(id).then((response) => {
                    this.alerts.push({'type': response.data.msg_type,'msg': response.data.msg, 'show': 10,'down': 0});
                    if (response.data.code == 0) {
                        this.items = this.items.filter(item => item.id != id);
                        this.total = this.total - 1;
                    }
                }).catch((error)=>{
                    this.alerts.push({'type': 'danger','msg': '系统出错，请联系管理员查看','show': 10,'down': 0});
                    console.log(error);
                });
            },
            resetModal(){
                this.deleteForm = Object.assign({}, deleteForm);
                this.$bvModal.hide('modal-element-delete')
            }
        }
    }
</script>

<style scoped>

</style>
