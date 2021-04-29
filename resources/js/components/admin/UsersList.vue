<template>
    <div class="col-12">
        <button v-if="dataUserState.levels.indexOf('admin') >= 0"
            class="btn btn-add-table d-flex align-items-center ml-auto py-3 px-4 mr-3" 
            @click="openModal(null, 'create')">
            <i class="gg-math-plus mr-3"></i>
            Add User
        </button>

        <users-modal v-if="dataUserState.levels.indexOf('admin') >= 0"
            :modal_id="this.dataModalID" 
            @onSubmitFormUsers="getUsers" 
            ref="users_modal" />

        <div class="table-responsive pt-4 pr-3">
            <table id="table-control-user" class="table table-hover table-striped table-borderless">
                <thead>
                    <tr>
                        <th scope="col" class="font-weight-bold text-truncate">#</th>
                        <th scope="col" class="font-weight-bold text-truncate">Name</th>
                        <th scope="col" class="font-weight-bold text-truncate">Email</th>
                        <th scope="col" class="font-weight-bold text-truncate">Date</th>
                        <th v-if="dataUserState.levels.indexOf('admin') >= 0" 
                            scope="col" class="font-weight-bold text-truncate">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in this.dataUsers" :key="index" :id="user.id">
                        <th scope="row" class="text-truncate">{{ user.id }}</th>
                        <td class="text-truncate d-flex align-items-center">
                            <img :src="`${dataMainPage}/img/${user.image||'user_default.svg'}`" class="rounded-circle shadow mr-3" width="30" height="30">
                            {{ user.name }}
                        </td>
                        <td class="text-truncate">{{ user.email }}</td>
                        <td class="text-truncate">{{ user.date }}</td>
                        <td v-if="dataUserState.levels.indexOf('admin') >= 0"
                            class="text-truncate d-flex justify-content-end">
                            <button class="btn" type="button" aria-haspopup="true" aria-expanded="false" 
                                @click="openModal(dataUsers[index], 'update')" style="box-shadow: none">
                                <i class="gg-pen mx-auto"></i>
                            </button>

                            <button class="btn" type="button" aria-haspopup="true" aria-expanded="false" 
                                @click="remove(user.id)" style="box-shadow: none">
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
import UsersModal from './UsersModal';

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
        paginator, UsersModal
    },

    data() {
        return {
            dataUserState: this.$store.state.user,
            dataUsers: [],
            dataUser: null,
            dataPaginate: this.paginate,
            dataCurrentPage: 1,
            dataLastPage: 1,
            dataMainPage: window.location.origin,
            dataModalID: 'newUserModal',
            dataType: 'create',
            dataLoading: true
        };
    },

    beforeCreate() {},
    created() {},
    beforeMount() {},
    mounted() {
        this.getUsers(this.dataCurrentPage);
    },
    beforeUpdate() {},
    updated() {},
    beforeDestroy() {},
    destroyed() {},

    methods: {
        getUsers() {
            this.dataLoading = true;

            this.$axios.get(`/api/admin/user/index?paginate=${this.dataPaginate}&page=${this.dataCurrentPage}`).then(response => {
                if (response.status == 200) {
                    this.dataUsers = response.data.data;
                    this.dataCurrentPage = response.data.meta.current_page;
                    this.$refs.paginator.dataLastPage = response.data.meta.last_page;
                    this.$refs.paginator.dataCurrentPage = this.dataCurrentPage;

                    this.dataLoading = false;

                } else {
                    console.warn(response);
                }

            }).catch(error => {
                console.error('UsersList.vue - Exception on method getUsers()', error);
            });
        },

        openModal(data, type) {            
            this.$refs.users_modal.dataUser = (data || this.createDefaultObject());
            this.$refs.users_modal.dataType = type;
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
                    this.$axios.delete(`/api/admin/user/delete`, {
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
                                this.getUsers();

                            } else {
                                swal('Ops', (data.message || 'Error'), 'error');
                            }
                            
                        } else {
                            console.warn(response);
                        }
                    }).catch(error => {
                        console.error('UsersList.vue - Exception on method remove()', error);
                    });
                }
            });
        },

        createDefaultObject() {
            return {
                id: null,
                name: null,
                email: null,
                image: null
            };
        },

        paginateChanged(data) {
            this.dataPaginate = data ? parseInt(data) : 10;
            this.getUsers();
        },

        loadPage(data) {
            this.dataCurrentPage = data;
            this.getUsers();
        }
    }
};
</script>

<style scoped>

</style>