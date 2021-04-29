<template>
    <div class="col-12">
        <button v-if="dataUser.levels.indexOf('admin') >= 0"
            class="btn btn-add-table d-flex align-items-center ml-auto py-3 px-4 mr-3" 
            @click="openModal(null, 'create')">
            <i class="gg-math-plus mr-3"></i>
            Add Level
        </button>

        <levels-modal v-if="dataUser.levels.indexOf('admin') >= 0"
            :modal_id="this.dataModalID" 
            @onSubmitFormLevel="getLevels" 
            ref="levels_modal" />

        <div class="table-responsive pt-4 pr-3">
            <table id="table-control-level" class="table table-hover table-striped table-borderless">
                <thead>
                    <tr>
                        <th scope="col" class="font-weight-bold text-truncate">#</th>
                        <th scope="col" class="font-weight-bold text-truncate">Type</th>
                        <th scope="col" class="font-weight-bold text-truncate">Can view</th>
                        <th scope="col" class="font-weight-bold text-truncate">Date</th>
                        <th v-if="dataUser.levels.indexOf('admin') >= 0" 
                            scope="col" class="font-weight-bold text-truncate">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(level, index) in this.dataLevels" :key="index" :id="level.id">
                        <th scope="row" class="text-truncate">{{ level.id }}</th>
                        <td class="text-truncate">{{ level.type }}</td>
                        <td class="text-truncate">{{ level.can_view }}</td>
                        <td class="text-truncate">{{ level.date }}</td>
                        <td v-if="dataUser.levels.indexOf('admin') >= 0"
                            class="text-truncate d-flex justify-content-end">
                            <button class="btn" type="button" aria-haspopup="true" aria-expanded="false" 
                                @click="openModal(dataLevels[index], 'update')" style="box-shadow: none">
                                <i class="gg-pen mx-auto"></i>
                            </button>

                            <button class="btn" type="button" aria-haspopup="true" aria-expanded="false" 
                                @click="remove(level.id)" style="box-shadow: none">
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
import LevelsModal from './LevelsModal';

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
        paginator, LevelsModal
    },

    data() {
        return {
            dataUser: this.$store.state.user,
            dataLevels: [],
            dataLevel: null,
            dataPaginate: this.paginate,
            dataCurrentPage: 1,
            dataLastPage: 1,
            dataModalID: 'newLevelModal',
            dataType: 'create',
            dataLoading: true
        };
    },

    beforeCreate() {},
    created() {},
    beforeMount() {},
    mounted() {
        this.getLevels(this.dataCurrentPage);
    },
    beforeUpdate() {},
    updated() {},
    beforeDestroy() {},
    destroyed() {},

    methods: {
        getLevels() {
            this.dataLoading = true;

            this.$axios.get(`/api/admin/level/index?paginate=${this.dataPaginate}&page=${this.dataCurrentPage}`).then(response => {
                if (response.status == 200) {
                    this.dataLevels = response.data.data;
                    this.dataCurrentPage = response.data.meta.current_page;
                    this.$refs.paginator.dataLastPage = response.data.meta.last_page;
                    this.$refs.paginator.dataCurrentPage = this.dataCurrentPage;

                    this.dataLoading = false;

                } else {
                    console.warn(response);
                }

            }).catch(error => {
                console.error('LevelsList.vue - Exception on method getLevels()', error);
            });
        },

        openModal(data, type) {            
            this.$refs.levels_modal.dataLevel = (data || this.createDefaultObject());
            this.$refs.levels_modal.dataType = type;
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
                    this.$axios.delete(`/api/admin/level/delete`, {
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
                                this.getLevels();

                            } else {
                                swal('Ops', (data.message || 'Error'), 'error');
                            }
                            
                        } else {
                            console.warn(response);
                        }
                    }).catch(error => {
                        console.error('LevelsList.vue - Exception on method remove()', error);
                    });
                }
            });
        },

        createDefaultObject() {
            return {
                id: null,
                type: null,
                can_view: [
                    'customers', 'numbers', 'numbers_preferences', 'users', 'levels', 'logs'
                ]
            };
        },

        paginateChanged(data) {
            this.dataPaginate = data ? parseInt(data) : 10;
            this.getLevels();
        },

        loadPage(data) {
            this.dataCurrentPage = data;
            this.getLevels();
        }
    }
};
</script>

<style scoped>

</style>