<template>
    <div>
        <p>TODO: List of customers</p>
    </div>
</template>

<script>
export default {
    props: {},
    computed: {},
    watch: {},
    components: {},

    data() {
        return {
            dataCustomers: []
        };
    },

    beforeCreate() {},
    created() {},
    beforeMount() {},
    mounted() {
        this.getCustomers();
    },
    beforeUpdate() {},
    updated() {},
    beforeDestroy() {},
    destroyed() {},

    methods: {
        getCustomers() {
            this.$axios.get('/api/admin/customer/getCustomers').then(response => {
                if (response.status == 200) {
                    this.dataCustomers = response.data.data;

                } else {
                    console.warn(response);
                }

            }).catch(error => {
                console.error('CustomersList.vue - Exception on method getCustomers()', error);
            });
        }
    }
};
</script>

<style scoped>

</style>