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
                    <b-pagination v-model="form.page" :total-rows="total"
                                  :per-page="form.limit" class="my-0"/>
                    <b-card-text class="mt-3 text-secondary">共 {{ total }} 条数据</b-card-text>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    import {getData} from "../../api/element";

    const defaultForm = {
        router_id: null,
        page: 1,
        limit: 20,
    };
    export default {
        name: "ElementList",
        props:{
            'router-id': {
                default: null
            }
        },
        watch:{
            routerId(value){
                console.log(value)
                this.form.router_id = value;
                this.getElement()
            }
        },
        data(){
            return {
                elements: [],
                total: 0,
                isBusy: true,
                sortBy: 'id',
                sortDesc: false,
                form: Object.assign({router_id: this.routerId}, defaultForm),
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
        methods: {
            openDeleteModal(){},
            openEditModal(){},
            getElement() {
                getData(this.form).then(response => {
                    if (response.data.code == 0) {
                        this.isBusy = false;
                        this.elements = response.data.data.data;
                        this.form.page = response.data.data.current_page;
                        this.total = response.data.data.total;
                    } else {
                        this.$parent.alerts.push({'type': 'danger', 'msg': response.data.msg, 'show': 10, 'down': 0});
                        console.log(response);
                    }
                }).catch(error => {
                    this.$parent.alerts.push({'type': 'danger', 'msg': '系统出错，请联系管理员查看', 'show': 10, 'down': 0});
                    console.log(error);
                });
            },
            addElement(){},
        }
    }
</script>

<style scoped>

</style>
