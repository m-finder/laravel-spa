<template>
    <b-modal centered :title="title" v-model="show" @hidden="resetModal">
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">角色名称-英</span>
                </div>
                <input type="text" name="name" v-model="form.name"
                       class="form-control" placeholder="角色名称">
            </div>
        </div>
        <div class="col-lg-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">角色别名-中</span>
                </div>
                <input type="text" name="alias"  v-model="form.alias"
                       class="form-control" placeholder="角色别名">
            </div>
        </div>
        <div slot="modal-footer" class="w-100">
            <b-button variant="primary" size="sm" @click="resetModal">取消</b-button>
            <b-button :disabled="disabled" variant="danger" size="sm" @click="submitUpdate">确认</b-button>
        </div>
    </b-modal>
</template>

<script>
    import {getDetail, updateData} from "../../api/role";

    const defaultForm = {
        id: null,
        name:null,
        alias: null
    };
    export default {
        name: "RoleEdit",
        props: {
            id: {
                default: null
            },
            isEdit: {
                type: Boolean,
                default: false
            },
            title: {
                type: String,
                default: '编辑操作'
            }
        },
        data() {
            return {
                form: Object.assign({}, defaultForm),
                show: this.isEdit,
                disabled: true,
            }
        },
        watch: {
            isEdit(value){
                this.show = value;
                if(value){
                    this.disabled = true;
                    this.getDetail();
                }
            }
        },
        methods: {
            getDetail() {
                getDetail(this.id).then(res => {
                    if (res.data.code == 0) {
                        this.form = res.data.data;
                        this.disabled = false;
                    } else {
                        this.$parent.alerts.push({'type': 'danger', 'msg': res.data.msg, 'show': 10, 'down': 0});
                        console.log(res);
                    }
                })
            },
            checkForm() {
                if(!this.form.id){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '角色获取失败'});
                    return false;
                }
                if(!this.form.name){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入角色名'});
                    return false;
                }
                if(!this.form.alias){
                    this.$parent.alerts.push({'type': 'danger','show': 10,'down': 0,'msg': '请输入角色别名'});
                    return false;
                }
                return true;
            },
            submitUpdate() {
                if (this.checkForm()) {
                    updateData(this.form).then(response => {
                        this.$parent.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0 });
                        if (response.data.code == 0) {
                            this.$parent.getList();
                            this.cancel()
                        }
                    }).catch((error) => {
                        this.$parent.alerts.push({'type': 'danger', 'msg': error.toString(), 'show': 10, 'down': 0});
                        console.log(error)
                    })
                }
            },
            cancel() {
                this.$bvModal.hide('modal-edit')
            },
            resetModal() {
                this.form = Object.assign({}, defaultForm);
                this.show = false;
                this.$parent.isEdit = false;
            }
        }
    }
</script>

<style scoped>

</style>
