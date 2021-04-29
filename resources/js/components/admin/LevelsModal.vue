<template>
    <div class="modal fade" :id="this.dataModalID" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <form id="form-level" class="needs-validation w-100" novalidate @submit="saveLevel" @submit.stop.prevent>
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title font-weight-bold text-center w-100">Level</h2>
                    </div>
                    
                    <div class="modal-body" v-if="dataLevel">
                        <!-- LEVEL DATA -->
                        <div class="row">
                            <input type="hidden" id="id" v-model="dataLevel.id">

                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="type">Type*:</label>
                                <input type="text" id="type" name="type" 
                                    autocomplete="off" spellcheck="false" class="form-control"
                                    required="required" v-model="dataLevel.type">
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="can_view">Can view*:</label>
                                <multiselect
                                    v-model="dataLevel.can_view"
                                    :options="dataOptions"
                                    :multiple="true"
                                    :preserve-search="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preselect-first="false">
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
            dataLevel: null,
            dataType: 'create',
            dataModalButtonSave: {
                text: 'SAVE',
                disabled: this.modal_button_save_disabled
            },
            dataOptions: [
                'customers','numbers','numbers_preferences','users','levels','logs'
            ] 
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
        saveLevel() {
            let form = $("#form-level")[0];

            if (form.checkValidity() && this.dataLevel.can_view) {
                this.dataModalButtonSave.text = "Loading...";
                this.dataModalButtonSave.disabled = true;

                if (this.dataType == 'create')
                    this.create();
                else
                    this.update();

            } else {
                $("#form-level").addClass('was-validated');
                this.$swal('Warning', 'Fill in the fields correctly and try again!', 'warning');
            }
        },

        create() {
            this.$axios.post(`/api/admin/level/create`, {
                type: this.dataLevel.type,
                can_view: JSON.stringify(this.dataLevel.can_view)
            }).then(response => {
                if (response.status == 200) {
                    let data = response.data.data

                    if (data.status) {
                        this.dataType = 'update';
                        swal('Success', (data.message || 'OK'), 'success');
                        this.$emit('onSubmitedFormLevel');
                        

                    } else {
                        swal('Ops', (data.message || 'Error'), 'error');
                    }
                    
                } else {
                    console.warn(response);
                }
                
                this.cleanButtonSave();

            }).catch(error => {
                console.error('LevelsModal.vue - Exception on method create()', error);
                this.cleanButtonSave();
            });
        },

        update() {
            this.$axios.put(`/api/admin/level/update`, {
                id: this.dataLevel.id,
                type: this.dataLevel.type,
                can_view: JSON.stringify(this.dataLevel.can_view)
            }).then(response => {
                if (response.status == 200) {
                    let data = response.data.data

                    if (data.status) {
                        swal('Success', (data.message || 'OK'), 'success');
                        this.$emit('onSubmitedFormLevel');

                    } else {
                        swal('Ops', (data.message || 'Error'), 'error');
                    }
                    
                } else {
                    console.warn(response);
                }

                this.cleanButtonSave();

            }).catch(error => {
                console.error('LevelsModal.vue - Exception on method update()', error);
                this.cleanButtonSave();
            });
        },

        cleanButtonSave() {
            this.dataModalButtonSave.text = "SAVE";
            this.dataModalButtonSave.disabled = false;
        },
    }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>

</style>