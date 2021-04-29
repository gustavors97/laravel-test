<template>
    <div class="modal fade" :id="this.dataModalID" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <form id="form-number-preference" class="needs-validation w-100" novalidate @submit="saveNumberPreference" @submit.stop.prevent>
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title font-weight-bold text-center w-100">Number Preference</h2>
                    </div>
                    
                    <div class="modal-body" v-if="dataNumberPreference">
                        <!-- NUMBER PREFERENCE DATA -->
                        <div class="row">
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="name">Name*:</label>
                                <input type="text" id="name" class="form-control" 
                                    autocomplete="off" spellcheck="false" 
                                    required="required" v-model="dataNumberPreference.name">
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="value">Value*:</label>
                                <input type="text" id="value" class="form-control" 
                                    autocomplete="off" spellcheck="false" 
                                    required="required" v-model="dataNumberPreference.value">
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div class="form-group col-12 mb-3">
                                <label for="can_view">Number*:</label>
                                <multiselect
                                    v-model="dataNumberPreference.number"
                                    :options="dataNumbers || []"
                                    :multiple="false"
                                    :preserve-search="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preselect-first="false"
                                    :custom-label="customLabelNumber"
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

    data() {
        return {
            dataModalID: this.modal_id,
            dataNumberPreference: null,
            dataType: 'create',
            dataModalButtonSave: {
                text: 'SAVE',
                disabled: this.modal_button_save_disabled
            },
            dataNumbers: this.getNumbers()
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
        saveNumberPreference() {
            let form = $("#form-number-preference")[0];

            if (form.checkValidity() && this.dataNumberPreference.number) {
                this.dataModalButtonSave.text = "Loading...";
                this.dataModalButtonSave.disabled = true;

                if (this.dataType == 'create')
                    this.create();
                else
                    this.update();

            } else {
                $("#form-number-preference").addClass('was-validated');
                this.$swal('Warning', 'Fill in the fields correctly and try again!', 'warning');
            }
        },

        getNumbers() {
            this.$axios.get(`/api/admin/number/getNumbers`).then(response => {
                if (response.status == 200) {
                    this.dataNumbers = response.data.data;
                } else {
                    console.warn(response);
                }

            }).catch(error => {
                console.error('NumbersPreferencesModal.vue - Exception on method getNumbers()', error);
            });
        },

        create() {
            this.$axios.post(`/api/admin/number_preference/create`, {
                number_id: this.dataNumberPreference.number.id,
                name: this.dataNumberPreference.name,
                value: this.dataNumberPreference.value
            }).then(response => {
                if (response.status == 200) {
                    let data = response.data.data

                    if (data.status) {
                        this.dataType = 'update';
                        swal('Success', (data.message || 'OK'), 'success');
                        this.$emit('onSubmitedFormNumberPreference');
                        

                    } else {
                        swal('Ops', (data.message || 'Error'), 'error');
                    }
                    
                } else {
                    console.warn(response);
                }
                
                this.cleanButtonSave();

            }).catch(error => {
                console.error('NumbersPreferencesModal.vue - Exception on method create()', error);
                this.cleanButtonSave();
            });
        },

        update() {
            this.$axios.put(`/api/admin/number_preference/update`, {
                id: this.dataNumberPreference.id,
                number_id: this.dataNumberPreference.number.id,
                name: this.dataNumberPreference.name,
                value: this.dataNumberPreference.value
            }).then(response => {
                if (response.status == 200) {
                    let data = response.data.data

                    if (data.status) {
                        swal('Success', (data.message || 'OK'), 'success');
                        this.$emit('onSubmitedFormNumberPreference');

                    } else {
                        swal('Ops', (data.message || 'Error'), 'error');
                    }
                    
                } else {
                    console.warn(response);
                }

                this.cleanButtonSave();

            }).catch(error => {
                console.error('NumbersPreferencesModal.vue - Exception on method update()', error);
                this.cleanButtonSave();
            });
        },
        
        cleanButtonSave() {
            this.dataModalButtonSave.text = "SAVE";
            this.dataModalButtonSave.disabled = false;
        },

        customLabelNumber({ number }) {
            return `${number}`;
        }
    }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>

</style>