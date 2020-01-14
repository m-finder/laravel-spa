<template>
    <section class="content container-fluid">

        <b-row class="p-3">
            <b-col md="6" sm="12">

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">资料设置</h3>
                    </div>

                    <div class="card-body">
                        <img class="avatar" :src="form.avatar || '/images/avatar.png'">
                    </div>
                </div>
            </b-col>
        </b-row>
    </section>
</template>

<script>
    import storage from "../../utils/storage";

    const defaultForm = {
        avatar: null,
        name: null,
    };
    export default {
        name: "Info",
        data() {
            return {
                form: Object.assign(storage.get('user-info') || storage.sessionGet('user-info'), defaultForm)
            }
        },
        created() {
            console.log(this.form)
        }
    }
</script>

<style lang="scss" scoped>

    .avatar {
        width: 200px;
        height: 200px;
    }
</style>
