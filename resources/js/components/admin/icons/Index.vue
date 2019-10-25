<template>
    <div>
        <div v-for="item of icons" :key="item">
            <div class="icon-item">
                <svg-icon :icon-class="item" class-name="disabled" />
                <span>{{ item }}</span>
            </div>
        </div>
    </div>
</template>

<script>
    import icons from './svg-icons'
    export default {
        name: "Index",
        data(){
            return {
                icons
            }
        },
        methods: {
            generateIconCode(symbol) {
                return `<svg-icon icon-class="${symbol}" />`
            },
        }
    }
</script>

<style lang="scss" scoped>
    .icons-container {
        margin: 10px 20px 0;
        overflow: hidden;

        .icon-item {
            margin: 20px;
            height: 85px;
            text-align: center;
            width: 100px;
            float: left;
            font-size: 30px;
            color: #24292e;
            cursor: pointer;
        }

        span {
            display: block;
            font-size: 16px;
            margin-top: 10px;
        }

        .disabled {
            pointer-events: none;
        }
    }
</style>
