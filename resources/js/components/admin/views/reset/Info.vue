<template>
    <section class="content container-fluid">

        <b-row class="p-3">
            <b-col md="6" sm="12">

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title mb-0">资料设置</h3>
                    </div>

                    <div class="card-body">
                        <img class="avatar" :src="getAvatar()"/>
                        <b-button @click="toggle" variant="outline-success">上传头像</b-button>
                        <avatar-uploader url="" img-format="jpg" img-bgc="#fff"
                                   v-model="show"
                                   field="avatar"
                                   @crop-success="cropSuccess"
                                   @crop-upload-success="cropUploadSuccess"
                                   @crop-upload-fail="cropUploadFail"
                                   :no-rotate="false"
                                   :headers="headers"/>

                    </div>
                </div>
            </b-col>
        </b-row>
    </section>
</template>

<script>
    import storage from "../../utils/storage";
    import uploader from 'vue-image-crop-upload';

    const defaultForm = {
        avatar: null,
        name: null,
    };
    export default {
        name: "Info",
        components: {
            'avatar-uploader': uploader
        },
        data() {
            return {
                headers: {},
                show: false,
                form: Object.assign(storage.get('user-info') || storage.sessionGet('user-info'), defaultForm)
            }
        },
        methods: {
            toggle(){
                let {show} = this;
                this.show = !show;
            },
            getAvatar(){
                return this.form.avatar || '/images/avatar.png';
            },
            cropSuccess(data, field, key) {
                this.form.avatar = data;
                console.log('-------- 剪裁成功 --------');
            },
            cropUploadSuccess(data, field, key) {
                console.log('-------- 上传成功 --------');
                console.log(data);
                console.log('field: ' + field);
                console.log('key: ' + key);
            },
            cropUploadFail(status, field, key) {
                console.log('-------- 上传失败 --------');
                console.log(status);
                console.log('field: ' + field);
                console.log('key: ' + key);
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
