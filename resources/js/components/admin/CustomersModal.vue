<template>
    <div class="modal fade" :id="this.dataModalID" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <form id="form-customer" class="needs-validation w-100" novalidate @submit="saveCustomer" @submit.stop.prevent>
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title font-weight-bold text-center w-100">Customer</h2>
                    </div>
                    
                    <div class="modal-body" v-if="dataCustomer">
                        <!-- CUSTOMER DATA -->
                        <div class="row">
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="name">Name*:</label>
                                <input type="text" id="name" name="name" 
                                    autocomplete="off" spellcheck="false" class="form-control"
                                    required="required" v-model="dataCustomer.name">
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="document">Document*:</label>
                                <input type="text" id="document" v-mask="'############'"
                                    autocomplete="off" spellcheck="false" class="form-control" 
                                    required="required" v-model="dataCustomer.document">
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="status">Customer status*:</label>
                                <select id="status" class="form-control" v-model="dataCustomer.status">
                                    <option value="new">New</option>
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="can_view">User*:</label>
                                <multiselect
                                    v-model="dataCustomer.user"
                                    :options="dataUsers || []"
                                    :multiple="false"
                                    :preserve-search="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preselect-first="false"
                                    :custom-label="customLabelUsers"
                                    track-by="id">
                                </multiselect>

                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>
                        </div>

                        <small class="font-italic text-muted mb-0">* Required fields</small>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary btn-modal px-4 py-2" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-modal px-4 py-2" :disabled="this.dataModalButtonSave.disabled">
                            {{ this.dataModalButtonSave.text }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import { mask } from 'vue-the-mask';
import Multiselect from "vue-multiselect";

export default {
    props: {
        modal_id: {
            type: String,
            required: true
        }
    },
    computed: {},
    watch: {},

    components: {
        Multiselect
    },

    directives: { mask },

    data() {
        return {
            dataModalID: this.modal_id,
            dataCustomer: null,
            dataType: 'create',
            dataModalButtonSave: {
                text: 'SAVE',
                disabled: this.modal_button_save_disabled
            },
            dataUsers: this.getUsers()
        };
    },

    beforeCreate() {},
    created() {},
    beforeMount() {},
    mounted() {},
    beforeUpdate() {},
    updated() {},
    beforeDestroy() {},
    destroyed() {},

    methods: {
        saveCustomer() {
            let form = $("#form-customer")[0];

            if (form.checkValidity() && this.dataCustomer.user) {
                this.dataModalButtonSave.text = "Loading...";
                this.dataModalButtonSave.disabled = true;

                if (this.dataType == 'create')
                    this.create();
                else
                    this.update();

            } else {
                $("#form-customer").addClass('was-validated');
                this.$swal('Warning', 'Fill in the fields correctly and try again!', 'warning');
            }
        },

        getUsers() {
            this.$axios.get(`/api/admin/user/getUsers`).then(response => {
                if (response.status == 200) {
                    this.dataUsers = response.data.data;
                } else {
                    console.warn(response);
                }

            }).catch(error => {
                console.error('UsersModal.vue - Exception on method getUsers()', error);
            });
        },

        create() {
            this.$axios.post(`/api/admin/customer/create`, {
                user_id: this.dataCustomer.user.id,
                name: this.dataCustomer.name,
                document: this.dataCustomer.document,
                status: this.dataCustomer.status,
                user: this.dataCustomer.user,
                numbers: this.dataCustomer.numbers
            }).then(response => {
                if (response.status == 200) {
                    let data = response.data.data

                    if (data.status) {
                        this.dataType = 'update';
                        swal('Success', (data.message || 'OK'), 'success');
                        this.$emit('onSubmitedFormCustomer');
                        

                    } else {
                        swal('Ops', (data.message || 'Error'), 'error');
                    }
                    
                } else {
                    console.warn(response);
                }
                
                this.cleanButtonSave();

            }).catch(error => {
                console.error('CustomersModal.vue - Exception on method create()', error);
                this.cleanButtonSave();
            });
        },

        update() {
            this.$axios.put(`/api/admin/customer/update`, {
                id: this.dataCustomer.id,
                user_id: this.dataCustomer.user.id,
                name: this.dataCustomer.name,
                document: this.dataCustomer.document,
                status: this.dataCustomer.status
            }).then(response => {
                if (response.status == 200) {
                    let data = response.data.data

                    if (data.status) {
                        swal('Success', (data.message || 'OK'), 'success');
                        this.$emit('onSubmitedFormCustomer');

                    } else {
                        swal('Ops', (data.message || 'Error'), 'error');
                    }
                    
                } else {
                    console.warn(response);
                }

                this.cleanButtonSave();

            }).catch(error => {
                console.error('CustomersModal.vue - Exception on method update()', error);
                this.cleanButtonSave();
            });
        },

        cleanButtonSave() {
            this.dataModalButtonSave.text = "SAVE";
            this.dataModalButtonSave.disabled = false;
        },

        customLabelUsers({ name }) {
            return `${name}`;
        }
    }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>

</style>