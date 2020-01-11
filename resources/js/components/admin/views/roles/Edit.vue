<template>
    <b-modal centered :title="title" v-model="show" @hidden="resetModal">
        <validation-observer ref="form">
            <b-col cols="12">
                <validation-provider vid="name" name="角色名称" rules="required" v-slot="{ errors }">
                    <b-input-group prepend="角色名称-英">
                        <b-input type="text" v-model="form.name" placeholder="角色名称" trim/>
                        <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-input-group>
                </validation-provider>
            </b-col>

            <b-col cols="12">
                <validation-provider vid="alias" name="角色别名" rules="required" v-slot="{ errors }">
                    <b-input-group prepend="角色别名-中">
                        <b-input type="text" v-model="form.alias" placeholder="角色别名" trim/>
                        <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                    </b-input-group>
                </validation-provider>
            </b-col>
        </validation-observer>

        <template slot="modal-footer" class="w-100 modal-footer">
            <b-button variant="primary" size="sm" @click="resetModal">取消</b-button>
            <b-button v-has="'role:edit'" :disabled="disabled" variant="danger" size="sm" @click="submitUpdate">确认
            </b-button>
        </template>
    </b-modal>
</template>

<script>
    import {getDetail, updateData} from "../../api/role";

    const defaultForm = {
        id: null,
        name: null,
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
            isEdit(value) {
                this.show = value;
                if (value) {
                    this.disabled = true;
                    this.getDetail();
                }
            }
        },
        methods: {
            getDetail() {
                getDetail(this.id).then(res => {
                    this.form = res.data;
                    this.disabled = false;
                })
            },
            submitUpdate() {
                this.$refs.form.validate().then(valid => {
                    if (valid) {
                        updateData(this.form).then(res => {
                            this.$toast.success('编辑成功。', 'Success');
                            this.resetModal();
                            this.$parent.getList();
                        }).catch(error => {
                            this.$refs.form.setErrors(error.response.data.errors);
                        })
                    }
                })
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
