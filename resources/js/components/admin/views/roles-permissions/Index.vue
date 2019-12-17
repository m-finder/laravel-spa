<template>
    <b-modal centered size="xl" :title="title" v-model="show" @hidden="resetModal">

        <div v-if="loading" class="text-center text-danger my-2">
            <b-spinner class="align-middle"></b-spinner>
            <strong>Loading...</strong>
        </div>

        <div>
            <template v-for="(item,i) in menus">
                <div class="card mb-3">
                    <h5 class="card-title border-bottom pl-2 pb-1 mt-2 mb-2 ">
                        <b-form-checkbox :value="item.id" switch @change="toggleMenu($event, item.id)"
                                         v-model="menuArray">
                            {{ item.title }}
                        </b-form-checkbox>
                    </h5>
                    <div class="card-body" v-if="item.elements">
                        <template v-for="(e,ei) in item.elements">
                            <b-form-checkbox :value="e.id" @change="toggleElement($event, e.id)" v-model="elementArray">
                                {{ e.name }}
                            </b-form-checkbox>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <div slot="modal-footer" class="w-100">
            <b-button variant="primary" size="sm" @click="resetModal">取消</b-button>
            <b-button :disabled="disabled" variant="danger" size="sm" @click="submitAssign">确认</b-button>
        </div>
    </b-modal>
</template>

<script>
    import {getAllWithElements} from '../../api/menu'

    export default {
        name: "RolePermission",
        props: {
            'is-assign': {
                type: Boolean,
                default: false
            },
            title: {
                type: String,
                default: '添加操作'
            },
            id: {
                default: null
            }
        },
        data() {
            return {
                show: this.isCreate,
                disabled: true,
                loading: true,
                menus: [],
                menuArray: [1],
                elementArray: [13, 5],
            }
        },
        watch: {
            isAssign(value) {
                this.show = value;
                if (value) {
                    this.disabled = true;
                    this.getMenus()
                }
            }
        },
        methods: {
            toggleMenu(checked, id) {
                checked ?  this.menuArray.push(id) : this.menuArray = this.menuArray.filter(item => item != id);
                console.log(this.menuArray)
            },
            toggleElement(checked, id) {
                checked ? this.elementArray.push(id) : this.elementArray = this.elementArray.filter(item => item != id);
                console.log(this.elementArray)
            },
            getMenus() {
                getAllWithElements().then(res => {
                    if (res.data.code == 0) {
                        this.loading = false;
                        this.disabled = false;
                        this.menus = res.data.data;
                    } else {
                        this.alerts.push({'type': 'danger', 'msg': res.data.msg, 'show': 10, 'down': 0});
                        console.log(res);
                    }
                }).catch(error => {
                    this.alerts.push({'type': 'danger', 'msg': '系统出错，请联系管理员查看', 'show': 10, 'down': 0});
                    console.log(error);
                });
            },
            submitAssign() {
                console.log(this.menuArray)
                console.log(this.elementArray)
            },
            resetModal() {
                this.show = false;
                this.$parent.isAssign = false;
            }
        }
    }
</script>

<style scoped>

</style>
