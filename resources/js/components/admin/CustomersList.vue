<template>
    <div class="col-12">
        <div class="table-responsive pt-4 pr-3">
            <table id="table-control-analitico" class="table table-hover table-control">
                <thead>
                    <tr>
                        <th scope="col" class="font-weight-bold text-truncate">#</th>
                        <th scope="col" class="font-weight-bold text-truncate">Customer</th>
                        <th scope="col" class="font-weight-bold text-truncate">Document</th>
                        <th scope="col" class="font-weight-bold text-truncate">Status</th>
                        <th scope="col" class="font-weight-bold text-truncate">Date</th>
                        <th scope="col" class="font-weight-bold text-truncate"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(customer, index) in this.dataCustomers" :key="index" :id="customer.id">
                        <td class="text-truncate">{{ customer.id }}</td>
                        <td class="text-truncate">{{ customer.name }}</td>
                        <td class="text-truncate">{{ customer.document }}</td>
                        <td class="text-truncate">{{ customer.status }}</td>
                        <td class="text-truncate">{{ customer.date }}</td>
                        <td class="text-truncate d-flex justify-content-end">
                            <a>
                                <i class="gg-more-alt my-2"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <paginator></paginator>
        </div>
    </div>
</template>

<script>

import paginator from '../util/Paginator';

export default {
    props: {
        paginate: {
            type: Number,
            default: 10
        },
        current_page: {
            type: Number,
            default: 1
        }
    },
    computed: {},
    watch: {},
    components: {
        paginator
    },

    data() {
        return {
            dataCustomers: [],
            dataPaginate: this.paginate,
            dataCurrentPage: 1
        };
    },

    beforeCreate() {},
    created() {},
    beforeMount() {},
    mounted() {
        this.getCustomers(this.dataCurrentPage);
    },
    beforeUpdate() {},
    updated() {},
    beforeDestroy() {},
    destroyed() {},

    methods: {
        getCustomers() {
            this.$axios.get(`/api/admin/customer/getCustomers?paginate=${this.dataPaginate}&page=${this.dataCurrentPage}`).then(response => {
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