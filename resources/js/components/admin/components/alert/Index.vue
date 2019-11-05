<template>
    <div class="alert-panel">
        <b-alert v-for="(alert, index) in alerts" v-bind:key="index" :variant="alert.type"
                 :show="alert.show" @dismissed="alert.down=0"
                 @dismiss-count-down="countDownChanged($event,index)" dismissible>
            {{ alert.msg }}
            <b-progress variant="primary" :max="alert.show" :value="alert.down" height="4px"/>
        </b-alert>
    </div>
</template>
<script>
    export default {
        props: {
            alerts: {
                type: Array
            }
        },
        methods: {
            countDownChanged(dismissCountDown, index) {
                this.alerts[index].down = dismissCountDown
            },
        }
    }
</script>
