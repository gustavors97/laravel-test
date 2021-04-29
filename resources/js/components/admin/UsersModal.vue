<template>
    <div class="modal fade" :id="this.dataModalID" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <form id="form-user" class="needs-validation w-100" novalidate @submit="saveUser" @submit.stop.prevent>
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title font-weight-bold text-center w-100">User</h2>
                    </div>
                    
                    <div class="modal-body" v-if="dataUser">
                        <!-- USER DATA -->
                        <div class="row">
                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="name">Name*:</label>
                                <input type="text" id="name" name="name" 
                                    autocomplete="off" spellcheck="false" class="form-control"
                                    required="required" v-model="dataUser.name">
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div v-if="this.dataType == 'create'"  class="form-group col-12 col-md-6 mb-3">
                                <label for="email">Email*:</label>
                                <input type="email" id="email" name="email" 
                                    autocomplete="off" spellcheck="false" class="form-control"
                                    required="required" v-model="dataUser.email">
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div v-if="this.dataType == 'create'" class="form-group col-12 col-md-6 mb-3">
                                <label for="password1">Password*:</label>
                                <input type="password" id="password1" name="password1" 
                                    autocomplete="off" spellcheck="false" class="form-control"
                                    required="required" v-model="dataUserPassword1">
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div  v-if="this.dataType == 'create'" class="form-group col-12 col-md-6 mb-3">
                                <label for="password2">Repeat your password*:</label>
                                <input type="password" id="password2" name="password2" 
                                    autocomplete="off" spellcheck="false" class="form-control"
                                    required="required" v-model="dataUserPassword2">
                                <small class="invalid-feedback">Please, fill this field!</small>
                            </div>

                            <div class="form-group col-12 col-md-6 mb-3">
                                <label for="can_view">Levels*:</label>
                                <multiselect
                                    v-model="dataUser.levels"
                                    :options="dataLevels"
                                    :multiple="true"
                                    :preserve-search="true"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preselect-first="false"
                                    :custom-label="customLabelLevels"
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
            dataUser: null,
            dataType: 'create',
            dataModalButtonSave: {
                text: 'SAVE',
                disabled: this.modal_button_save_disabled
            },
            dataLevels: this.getLevels(),
            dataUserPassword1: null,
            dataUserPassword2: null
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
        saveUser() {
            let form = $("#form-user")[0];

            if (form.checkValidity() && this.dataUser.levels) {
                if (this.dataType == 'create' && (this.dataUserPassword1 != this.dataUserPassword2)) {
                    this.$swal('Warning', 'Passwords are differents!', 'warning');
                    return;
                }

                this.dataModalButtonSave.text = "Loading...";
                this.dataModalButtonSave.disabled = true;

                if (this.dataType == 'create')
                    this.create();
                else
                    this.update();

            } else {
                $("#form-user").addClass('was-validated');
                this.$swal('Warning', 'Fill in the fields correctly and try again!', 'warning');
            }
        },

        getLevels() {
            this.$axios.get(`/api/admin/level/getLevels`).then(response => {
                if (response.status == 200) {
                    this.dataLevels = response.data.data;
                } else {
                    console.warn(response);
                }

            }).catch(error => {
                console.error('UsersModal.vue - Exception on method getLevels()', error);
            });
        },

        create() {
            this.$axios.post(`/api/admin/user/create`, {
                name: this.dataUser.name,
                email: this.dataUser.email,
                password: this.dataUserPassword1,
                // image: this.dataUser.image,
                levels: this.dataUser.levels
            }).then(response => {
                if (response.status == 200) {
                    let data = response.data.data

                    if (data.status) {
                        this.dataType = 'update';
                        swal('Success', (data.message || 'OK'), 'success');
                        this.$emit('onSubmitedFormUser');
                        

                    } else {
                        swal('Ops', (data.message || 'Error'), 'error');
                    }
                    
                } else {
                    console.warn(response);
                }
                
                this.cleanButtonSave();

            }).catch(error => {
                console.error('UsersModal.vue - Exception on method create()', error);
                this.cleanButtonSave();
            });
        },

        update() {
            this.$axios.put(`/api/admin/user/update`, {
                id: this.dataUser.id,
                name: this.dataUser.name,
                email: this.dataUser.email,
                // image: this.dataUser.image
                levels: this.dataUser.levels
            }).then(response => {
                if (response.status == 200) {
                    let data = response.data.data

                    if (data.status) {
                        swal('Success', (data.message || 'OK'), 'success');
                        this.$emit('onSubmitedFormUser');

                    } else {
                        swal('Ops', (data.message || 'Error'), 'error');
                    }
                    
                } else {
                    console.warn(response);
                }

                this.cleanButtonSave();

            }).catch(error => {
                console.error('UsersModal.vue - Exception on method update()', error);
                this.cleanButtonSave();
            });
        },

        cleanButtonSave() {
            this.dataModalButtonSave.text = "SAVE";
            this.dataModalButtonSave.disabled = false;
        },

        customLabelLevels({ type }) {
            return `${type}`;
        }
    }
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>

</style>