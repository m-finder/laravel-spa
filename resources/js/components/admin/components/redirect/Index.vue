<script>
    export default {
        beforeCreate() {
            const { params, query } = this.$route
            const { path } = params
            console.log(path)
            console.log(params)
            console.log(query)
            this.$router.replace({ path: '/' + path, query })
        },
        render: function(h) {
            return h()
        }
    }
</script>
