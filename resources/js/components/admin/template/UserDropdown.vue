<template>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img :src="`${this.dataMainPage}/img/${this.dataUser.image||'user_default.svg'}`" class="rounded-circle shadow" width="50" height="50">
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <span class="btn dropdown-item" @click="exit">
                Sign out
            </span>
        </div>
    </li>
</template>

<script>
export default {
    props: {},
    computed: {},
    watch: {},
    components: {},

    data() {
        return {
            dataUser: this.$store.state.user,
            dataMainPage: window.location.origin
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
        exit() {
            this.$store.commit('clearUserData');
            window.location = '/logout';
        }
    }
};
</script>

<style scoped>

</style>