<template>
    <div class="container d-flex align-items-center p-3" style="min-height: 100vh">
        <form class="container d-flex flex-column justify-content-center">
            <div class="row">
                <img src="https://vaitel.com/wp-content/uploads/2020/06/vai_50x123_trans.png" alt="VAITEL" class="mb-5 mx-auto d-flex" style="width: 180px;">
            </div>

            <div class="form-group col-12 col-md-6 mx-auto d-flex align-items-center input-login">
                <span class="d-flex mx-2">
                    <i class="gg-profile"></i>
                </span>
                <input id="email" type="email" name="email" value="admin@admin.com" class="text-white w-100"
                    placeholder="Email" required autofocus autocomplete="off">
            </div>

            <div class="form-group col-12 col-md-6 mx-auto d-flex align-items-center input-login">
                <span class="d-flex mx-2">
                    <i class="gg-lock"></i>
                </span>
                <input id="password" type="password" name="password" value="admin" class="text-white w-100"
                    placeholder="Password" required autocomplete="off">
            </div>

            <button class="col-12 col-md-6 btn-login mx-auto font-weight-bold text-white" type="submit">Get Started</button>

            <div class="row col-12 col-md-6 mx-auto mt-3">
                <span class="col-6 px-0 btn d-flex justify-content-start" href="https://vaitel.com/" style="color: #DDD">
                    Create Account
                </span>

                <span class="col-6 px-0 btn d-flex justify-content-end" href="https://support.2talk.com/portal/en/home" style="color: #DDD">
                    Need Help?
                </span>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: {},
    computed: {},
    watch: {},
    components: {},

    data() {
        return {};
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
</style>