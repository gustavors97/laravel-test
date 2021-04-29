<template>
    <div class="modal fade" :id="this.dataModalID" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <form id="form-number" class="needs-validation w-100" novalidate @submit="saveNumber" @submit.stop.prevent>
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title font-weight-bold text-center w-100">Number</h2>
                    </div>
                    
                    <div class="modal-body" v-if="dataNumber">
                        <!-- NUMBER DATA -->
                        <div class="row">
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="number">Number*:</label>
                                <input type="text" id="number" v-mask="'##############'"
                                    autocomplete="off" spellcheck="false" class="form-control" 
                                    required="required" v-model="dataNumber.number">
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="status">Status*:</label>
                                <select id="status" class="form-control" v-model="dataNumber.status">
                                    <option value="active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div class="form-group col-12 mb-3">
                                <label for="can_view">Customer*:</label>
                                <multiselect
                                    v-model="dataNumber.customer"
                                    :options="dataCustomers || []"
                                    :multiple="false"
                                    :preserve-search="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preselect-first="false"
                                    :custom-label="customLabelCustomer"
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
            dataNumber: null,
            dataType: 'create',
            dataModalButtonSave: {
                text: 'SAVE',
                disabled: this.modal_button_save_disabled
            },
            dataCustomers: this.getCustomers()
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
        saveNumber() {
            let form = $("#form-number")[0];

            if (form.checkValidity() && this.dataNumber.customer) {
                this.dataModalButtonSave.text = "Loading...";
                this.dataModalButtonSave.disabled = true;

                if (this.dataType == 'create')
                    this.create();
                else
                    this.update();

            } else {
                $("#form-number").addClass('was-validated');
                this.$swal('Warning', 'Fill in the fields correctly and try again!', 'warning');
            }
        },

        getCustomers() {
            this.$axios.get(`/api/admin/customer/getCustomers`).then(response => {
                if (response.status == 200) {
                    this.dataCustomers = response.data.data;
                } else {
                    console.warn(response);
                }

            }).catch(error => {
                console.error('NumbersModal.vue - Exception on method getCustomers()', error);
            });
        },

        create() {
            this.$axios.post(`/api/admin/number/create`, {
                customer_id: this.dataNumber.customer.id,
                number: this.dataNumber.number,
                status: this.dataNumber.status
            }).then(response => {
                if (response.status == 200) {
                    let data = response.data.data

                    if (data.status) {
                        this.dataType = 'update';
                        swal('Success', (data.message || 'OK'), 'success');
                        this.$emit('onSubmitedFormNumber');
                        

                    } else {
                        swal('Ops', (data.message || 'Error'), 'error');
                    }
                    
                } else {
                    console.warn(response);
                }
                
                this.cleanButtonSave();

            }).catch(error => {
                console.error('NumbersModal.vue - Exception on method create()', error);
                this.cleanButtonSave();
            });
        },

        update() {
            this.$axios.put(`/api/admin/number/update`, {
                id: this.dataNumber.id,
                customer_id: this.dataNumber.customer.id,
                number: this.dataNumber.number,
                status: this.dataNumber.status
            }).then(response => {
                if (response.status == 200) {
                    let data = response.data.data

                    if (data.status) {
                        swal('Success', (data.message || 'OK'), 'success');
                        this.$emit('onSubmitedFormNumber');

                    } else {
                        swal('Ops', (data.message || 'Error'), 'error');
                    }
                    
                } else {
                    console.warn(response);
                }

                this.cleanButtonSave();

            }).catch(error => {
                console.error('NumbersModal.vue - Exception on method update()', error);
                this.cleanButtonSave();
            });
        },

        cleanButtonSave() {
            this.dataModalButtonSave.text = "SAVE";
            this.dataModalButtonSave.disabled = false;
        },
        
        customLabelCustomer({ name }) {
            return `${name}`;
        }
    }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>

</style>