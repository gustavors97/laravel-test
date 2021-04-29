<template>
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <img :src="this.dataMainPage + '/img/favicon.svg'" alt="VAITEL" class="ml-3 mt-3 mb-4 mr-auto d-flex" width="80">
        </div>

        <div class="list-menu top-radius-corner h-100">
            <div class="list-group ml-3">
                <a v-if="this.dataUser.can_view.indexOf('customers') >= 0"
                    href="#" class="list-group-item my-2 d-flex align-items-center p-0"
                    :class="(this.dataCurrentLink == 'customers') ? 'menu-list-item-active' : ''"
                    @click="url('/admin/customers')">
                    <span class="mr-2 d-flex align-items-center justify-content-center">
                        <i class="gg-user"></i>
                    </span>
                    Customers
                </a>
                
                <a v-if="this.dataUser.can_view.indexOf('numbers') >= 0"
                    href="#" class="list-group-item my-2 d-flex align-items-center p-0"
                    :class="(this.dataCurrentLink == 'numbers') ? 'menu-list-item-active' : ''"
                    @click="url('/admin/numbers')">
                    <span class="mr-2 d-flex align-items-center justify-content-center">
                        <i class="gg-stark"></i>
                    </span>
                    Numbers
                </a>

                <a v-if="this.dataUser.can_view.indexOf('numbers_preferences') >= 0"
                    href="#" class="list-group-item my-2 d-flex align-items-center p-0"
                    :class="(this.dataCurrentLink == 'numbers_preferences') ? 'menu-list-item-active' : ''"
                    @click="url('/admin/numbers_preferences')">
                    <span class="mr-2 d-flex align-items-center justify-content-center">
                        <i class="gg-align-bottom"></i>
                    </span>
                    Numbers Preferences
                </a>

                <a v-if="this.dataUser.can_view.indexOf('users') >= 0"
                    href="#" class="list-group-item my-2 d-flex align-items-center p-0"
                    :class="(this.dataCurrentLink == 'users') ? 'menu-list-item-active' : ''"
                    @click="url('/admin/users')">
                    <span class="mr-2 d-flex align-items-center justify-content-center">
                        <i class="gg-girl"></i>
                    </span>
                    Users
                </a>

                <a v-if="this.dataUser.can_view.indexOf('levels') >= 0"
                    href="#" class="list-group-item my-2 d-flex align-items-center p-0"
                    :class="(this.dataCurrentLink == 'levels') ? 'menu-list-item-active' : ''"
                    @click="url('/admin/levels')">
                    <span class="mr-2 d-flex align-items-center justify-content-center">
                        <i class="gg-gitter"></i>
                    </span>
                    Levels
                </a>

                <a v-if="this.dataUser.can_view.indexOf('logs') >= 0"
                    href="#" class="list-group-item my-2 d-flex align-items-center p-0"
                    :class="(this.dataCurrentLink == 'logs') ? 'menu-list-item-active' : ''"
                    @click="url('/admin/logs')">
                    <span class="mr-2 d-flex align-items-center justify-content-center">
                        <i class="gg-file-document"></i>
                    </span>
                    Logs
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        current_link: {
            type: String,
            default: '#'
        }
    },
    computed: {},
    watch: {},
    components: {},

    data() {
        return {
            dataUser: this.$store.state.user,
            dataCurrentLink: this.current_link,
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
        url(link) {
            window.location = this.dataMainPage + link;
        }
    }
};
</script>

<style scoped>

</style>