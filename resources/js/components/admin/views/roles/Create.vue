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
            <b-button variant="danger" size="sm" @click="submitCreate">确认</b-button>
        </div>
    </b-modal>
</template>

<script>
    import {createData} from "../../api/role";
    const defaultForm = {
        name:null,
        alias: null
    };
    export default {
        name: "RoleCreate",
        props: {
            'is-create': {
                type: Boolean,
                default: false
            },
            title: {
                type: String,
                default: '添加操作'
            }
        },
        data() {
            return {
                form: Object.assign({}, defaultForm),
                show: this.isCreate
            }
        },
        watch: {
            isCreate(value){
                this.show = value;
            }
        },
        methods: {
            checkForm() {
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
            submitCreate() {
                if (this.checkForm()) {
                    createData(this.form).then(response => {
                        this.$parent.alerts.push({'type': response.data.msg_type,'msg': response.data.msg,'show': 10,'down': 0 });
                        if (response.data.code == 0) {
                            this.$parent.getList();
                            this.resetModal()
                        }
                    }).catch((error) => {
                        this.$parent.alerts.push({'type': 'danger', 'msg': error.toString(), 'show': 10, 'down': 0});
                        console.log(error)
                    })
                }
            },
            resetModal() {
                this.form = Object.assign({}, defaultForm);
                this.show = false;
                this.$parent.isCreate = false;
            }
        }
    }
</script>

<style scoped>

</style>
