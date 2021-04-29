<template>
    <div class="container d-flex align-items-center p-3" style="min-height: 100vh">
        <form class="container d-flex flex-column justify-content-center needs-validation" @submit="checkForm" @submit.stop.prevent novalidate>
            <div class="row">
                <img src="img/vai.svg" alt="VAITEL" class="mb-5 mx-auto d-flex" style="width: 220px">
            </div>

            <div class="form-group col-12 col-md-6 mx-auto d-flex align-items-center input-login has-feedback">
                <span class="d-flex mx-2">
                    <i class="gg-profile"></i>
                </span>

                <input id="email" type="email" name="email" value="" class="text-white w-100"
                    placeholder="Email" required autofocus autocomplete="off" v-model="form.email"
                    autocorrect="off" autocapitalize="off" spellcheck="false">
            </div>

            <div class="form-group col-12 col-md-6 mx-auto d-flex align-items-center input-login has-feedback">
                <span class="d-flex mx-2">
                    <i class="gg-lock ml-1"></i>
                </span>

                <input id="password" type="password" name="password" class="text-white w-100"
                    placeholder="Password" required autocomplete="off" v-model="form.password"
                    autocorrect="off" autocapitalize="off" spellcheck="false">
            </div>

            <button class="col-12 col-md-6 btn-login mx-auto font-weight-bold text-white" type="submit" :disabled="form.login.disabled">
                {{ form.login.text }}
            </button>

            <div v-if="errors.email.length || errors.password.length" class="col-12 col-md-6 mx-auto text-warning">
                <p v-for="error in errors.email" :key="error" class="my-2">{{ error }}</p>
                <p v-for="error in errors.password" :key="error" class="my-2">{{ error }}</p>
            </div>

            <div class="row col-12 col-md-6 mx-auto mt-3">
                <span class="col-6 px-0 btn d-flex justify-content-start info-link" @click="href('https://vaitel.com/')">
                    Create Account
                </span>

                <span class="col-6 px-0 btn d-flex justify-content-end info-link" @click="href('https://support.2talk.com/portal/en/home')">
                    Need Help?
                </span>
            </div>
        </form>
    </div>
</template>

<script>

import { mapGetters } from 'vuex';

export default {
    props: {},
    computed: {
         ...mapGetters({
            user: 'user'
        }),

        user: {
            get() {
                return this.user
            },
            set(user) {
                return user
            } 
        }
    },
    watch: {},
    components: {},

    data() {
        return {
            form: {
                email: 'admin@admin.com',
                password: 'admin',
                login: {
                    text: 'Get Started',
                    disabled: false
                }
            },
            errors: {
                email: [],
                password: []
            }
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
        checkForm() {
            this.errors.email = [];
            this.errors.password = [];

            if (!this.form.email) {
                this.errors.email.push('Please, enter your email correctly!');

            } else if (!this.form.password) {
                this.errors.password.push('Please, enter your password correctly!');

            } else {
                this.form.login.text = 'Loading...';
                this.form.login.disabled = true;

                this.$axios.post('/api/auth/login', {
                    email: this.form.email,
                    password: this.form.password
                }).then(response => {
                    if (response.status == 200) {
                        if (response.data.status) {
                            // Add userinfo in store
                            this.user = response.data.user;
                            this.$store.commit('userinfo', response.data.user);

                            // Redirect to admin page
                            window.location = (response.data.url || '/admin');

                        } else {
                            this.$swal('Ops', (response.data.message || 'Failed to login'), 'warning')
                            this.form.login.text = 'Get Started';
                            this.form.login.disabled = false;
                        }

                    } else {
                        console.warn(response);
                        this.form.login.text = 'Get Started';
                        this.form.login.disabled = false;
                    }

                }).catch(error => {
                    console.error('Login.vue - Exception on method checkForm()', error);
                    this.form.login.disabled = false;
                });
            }
        },

        href(link) {
            window.open(link);
        }
    }
};
</script>

<style scoped>
    .input-login {
        padding: 1.2rem 1rem;
        border-radius: 50px;
        background-color: rgba(255, 255, 255, .17);
        color: white;
    }

    .btn-login {
        padding: 1.2rem 1rem;
        border-radius: 50px;
        background: #00A9E9;
        color: white;
        border: none;
        outline: none;
    }

    .input-login > span {
        min-width: 30px;
    }

    .input-login > input {
        background-color: transparent;
        border: none;
        outline: none;
    }

    .info-link {
        color: #DDD
    }
</style>