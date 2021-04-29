<template>
    <div class="col-12">
        <button v-if="dataUser.levels.indexOf('admin') >= 0"
            class="btn btn-add-table d-flex align-items-center ml-auto py-3 px-4 mr-3" 
            @click="openModal(null, 'create')">
            <i class="gg-math-plus mr-3"></i>
            Add Number Preference
        </button>

        <numbers-preferences-modal v-if="dataUser.levels.indexOf('admin') >= 0"
            :modal_id="this.dataModalID" 
            @onSubmitedFormNumberPreference="getNumbersPreferences" 
            ref="numbers_preferences_modal" />

        <div class="table-responsive pt-4 pr-3">
            <table id="table-control-numbers-preferences" class="table table-hover table-striped table-borderless">
                <thead>
                    <tr>
                        <th scope="col" class="font-weight-bold text-truncate">#</th>
                        <th scope="col" class="font-weight-bold text-truncate">Customer</th>
                        <th scope="col" class="font-weight-bold text-truncate">Number</th>
                        <th scope="col" class="font-weight-bold text-truncate">Name</th>
                        <th scope="col" class="font-weight-bold text-truncate">Value</th>
                        <th scope="col" class="font-weight-bold text-truncate">Date</th>
                        <th v-if="dataUser.levels.indexOf('admin') >= 0" 
                            scope="col" class="font-weight-bold text-truncate">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(numberPreference, index) in this.dataNumbersPreferences" :key="index" :id="numberPreference.id">
                        <th scope="row" class="text-truncate">{{ numberPreference.id }}</th>
                        <td class="text-truncate">{{ numberPreference.customer.name }}</td>
                        <td class="text-truncate">{{ numberPreference.number.number }}</td>
                        <td class="text-truncate">{{ numberPreference.name }}</td>
                        <td class="text-truncate">{{ numberPreference.value }}</td>
                        <td class="text-truncate">{{ numberPreference.date }}</td>
                        <td v-if="dataUser.levels.indexOf('admin') >= 0"
                            class="text-truncate d-flex justify-content-end">
                            <button class="btn" type="button" aria-haspopup="true" aria-expanded="false" 
                                @click="openModal(dataNumbersPreferences[index], 'update')" style="box-shadow: none">
                                <i class="gg-pen mx-auto"></i>
                            </button>

                            <button class="btn" type="button" aria-haspopup="true" aria-expanded="false" 
                                @click="remove(numberPreference.id)" style="box-shadow: none">
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
import NumbersPreferences from './NumbersPreferencesModal';

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
        paginator, NumbersPreferences
    },

    data() {
        return {
            dataUser: this.$store.state.user,
            dataNumbersPreferences: [],
            dataNumberPreference: null,
            dataPaginate: this.paginate,
            dataCurrentPage: 1,
            dataLastPage: 1,
            dataModalID: 'newNumberPreferenceModal',
            dataType: 'create',
            dataLoading: true
        };
    },

    beforeCreate() {},
    created() {},
    beforeMount() {},
    mounted() {
        this.getNumbersPreferences(this.dataCurrentPage);
    },
    beforeUpdate() {},
    updated() {},
    beforeDestroy() {},
    destroyed() {},

    methods: {
        getNumbersPreferences() {
            this.dataLoading = true;

            this.$axios.get(`/api/admin/number_preference/index?paginate=${this.dataPaginate}&page=${this.dataCurrentPage}`).then(response => {
                if (response.status == 200) {
                    this.dataNumbersPreferences = response.data.data;
                    this.dataCurrentPage = response.data.meta.current_page;
                    this.$refs.paginator.dataLastPage = response.data.meta.last_page;
                    this.$refs.paginator.dataCurrentPage = this.dataCurrentPage;

                    this.dataLoading = false;

                } else {
                    console.warn(response);
                }

            }).catch(error => {
                console.error('NumbersPreferencesList.vue - Exception on method getNumbersPreferences()', error);
            });
        },

        openModal(data, type) {            
            this.$refs.numbers_preferences_modal.dataNumberPreference = (data || this.createDefaultObject());
            this.$refs.numbers_preferences_modal.dataType = type;
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
                    this.$axios.delete(`/api/admin/number_preference/delete`, {
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
                                this.getNumbersPreferences();

                            } else {
                                swal('Ops', (data.message || 'Error'), 'error');
                            }
                            
                        } else {
                            console.warn(response);
                        }
                    }).catch(error => {
                        console.error('NumbersPreferencesList.vue - Exception on method remove()', error);
                    });
                }
            });
        },

        createDefaultObject() {
            return {
                id: null,
                number_id: null,
                number: null,
                name: null,
                value: null
            };
        },

        paginateChanged(data) {
            this.dataPaginate = data ? parseInt(data) : 10;
            this.getNumbersPreferences();
        },

        loadPage(data) {
            this.dataCurrentPage = data;
            this.getNumbersPreferences();
        }
    }
};
</script>

<style scoped>

</style>