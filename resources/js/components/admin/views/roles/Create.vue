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
            <b-button v-has="'role:add'" variant="danger" size="sm" @click="submitCreate">确认</b-button>
        </template>
    </b-modal>
</template>

<script>
    import {createData} from "../../api/role";

    const defaultForm = {
        name: null,
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
            isCreate(value) {
                this.show = value;
            }
        },
        methods: {
            submitCreate() {
                this.$refs.form.validate().then(valid => {
                    if (valid) {
                        createData(this.form).then(res => {
                            this.$toast.success('添加成功。', 'Success');
                            this.$parent.getList();
                            this.resetModal()
                        }).catch(error => {
                            this.$refs.form.setErrors(error.response.data.errors);
                        })
                    }
                })
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
