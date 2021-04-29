<template>
    <div class="col-12">
        <button v-if="dataUser.levels.indexOf('admin') >= 0"
            class="btn btn-add-table d-flex align-items-center ml-auto py-3 px-4 mr-3" 
            @click="openModal(null, 'create')">
            <i class="gg-math-plus mr-3"></i>
            Add Number
        </button>

        <numbers-modal v-if="dataUser.levels.indexOf('admin') >= 0"
            :modal_id="this.dataModalID" 
            @onSubmitedFormNumber="getNumbers" 
            ref="numbers_modal" />

        <div class="table-responsive pt-4 pr-3">
            <table id="table-control-number" class="table table-hover table-striped table-borderless">
                <thead>
                    <tr>
                        <th scope="col" class="font-weight-bold text-truncate">#</th>
                        <th scope="col" class="font-weight-bold text-truncate">Customer</th>
                        <th scope="col" class="font-weight-bold text-truncate">Number</th>
                        <th scope="col" class="font-weight-bold text-truncate">Status</th>
                        <th scope="col" class="font-weight-bold text-truncate">Date</th>
                        <th v-if="dataUser.levels.indexOf('admin') >= 0" 
                            scope="col" class="font-weight-bold text-truncate">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(number, index) in this.dataNumbers" :key="index" :id="number.id">
                        <th scope="row" class="text-truncate">{{ number.id }}</th>
                        <td class="text-truncate">{{ number.customer.name }}</td>
                        <td class="text-truncate">{{ number.number }}</td>
                        <td class="text-truncate">{{ number.status }}</td>
                        <td class="text-truncate">{{ number.date }}</td>
                        <td v-if="dataUser.levels.indexOf('admin') >= 0"
                            class="text-truncate d-flex justify-content-end">
                            <button class="btn" type="button" aria-haspopup="true" aria-expanded="false" 
                                @click="openModal(dataNumbers[index], 'update')" style="box-shadow: none">
                                <i class="gg-pen mx-auto"></i>
                            </button>

                            <button class="btn" type="button" aria-haspopup="true" aria-expanded="false" 
                                @click="remove(number.id)" style="box-shadow: none">
                                <i class="gg-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <paginator :paginate="this.dataPaginate" :current_page="this.dataCurrentPage" ref="paginator"
                :last_page="this.dataLastPage" @onChangePaginate="paginateChanged($event)" @onLoadAnotherPage="loadPage($event)" />
        </div>
    </div>
</template>

<script>

import paginator from '../util/Paginator';
import NumbersModal from './NumbersModal';

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
        paginator, NumbersModal
    },

    data() {
        return {
            dataUser: this.$store.state.user,
            dataNumbers: [],
            dataNumber: null,
            dataPaginate: this.paginate,
            dataCurrentPage: 1,
            dataLastPage: 1,
            dataModalID: 'newNumberModal',
            dataType: 'create',
            dataLoading: true
        };
    },

    beforeCreate() {},
    created() {},
    beforeMount() {},
    mounted() {
        this.getNumbers(this.dataCurrentPage);
    },
    beforeUpdate() {},
    updated() {},
    beforeDestroy() {},
    destroyed() {},

    methods: {
        getNumbers() {
            this.dataLoading = true;

            this.$axios.get(`/api/admin/number/index?paginate=${this.dataPaginate}&page=${this.dataCurrentPage}`).then(response => {
                if (response.status == 200) {
                    this.dataNumbers = response.data.data;
                    this.dataCurrentPage = response.data.meta.current_page;
                    this.$refs.paginator.dataLastPage = response.data.meta.last_page;
                    this.$refs.paginator.dataCurrentPage = this.dataCurrentPage;

                    this.dataLoading = false;

                } else {
                    console.warn(response);
                }

            }).catch(error => {
                console.error('NumbersList.vue - Exception on method getNumbers()', error);
            });
        },

        openModal(data, type) {            
            this.$refs.numbers_modal.dataNumber = (data || this.createDefaultObject());
            this.$refs.numbers_modal.dataType = type;
            $(`#${this.dataModalID}`).modal('show');
        },

        remove(id) {
            this.$swal({
                title: "Are you sure?",
                icon: "warning",
                dangerMode: true,
                buttons: {
                    cancel: 'Cancel',
                    confirm: 'Confirm',
                }
            }).then((result) => {
                if (result) {
                    this.$axios.delete(`/api/admin/number/delete`, {
                        data: { 
                            id: id,
                            page: this.dataCurrentPage,
                            paginate: this.dataPaginate
                        }
                    }).then(response => {
                        if (response.status == 200) {
                            let data = response.data.data

                            if (data.status) {
                                swal('Success', (data.message || 'OK'), 'success');
                                this.getNumbers();

                            } else {
                                swal('Ops', (data.message || 'Error'), 'error');
                            }
                            
                        } else {
                            console.warn(response);
                        }
                    }).catch(error => {
                        console.error('NumbersList.vue - Exception on method remove()', error);
                    });
                }
            });
        },

        createDefaultObject() {
            return {
                id: null,
                customer: null,
                number: null,
                status: null
            };
        },

        paginateChanged(data) {
            this.dataPaginate = data ? parseInt(data) : 10;
            this.getNumbers();
        },

        loadPage(data) {
            this.dataCurrentPage = data;
            this.getNumbers();
        }
    }
};
</script>

<style scoped>

</style>