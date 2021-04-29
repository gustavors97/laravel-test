<template>
    <div class="row mt-3">
        <div class="col-2 d-flex justify-content-start py-3">
            <select :value="dataPaginate" v-model="dataPaginate" @change="changeSelect"
                class="form-control" style="width: 75px; box-shadow: none">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="20">20</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>

        <div class="col-10 d-flex justify-content-end">
            <ul class="pagination my-auto">
                <li v-for="index in this.dataLastPage" :key="index" class="pages">
                    <span class="mx-2 page-item" @click="loadPage(index)" :class="index == dataCurrentPage ? 'active-page' : ''">
                        {{ index }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        paginate: {
            type: Number,
            default: 10
        },
        current_page: {
            type: Number,
            default: 10
        },
        last_page: {
            type: Number,
            default: 1
        }
    },
    computed: {},
    watch: {},
    components: {},

    data() {
        return {
            dataPaginate: this.paginate,
            dataCurrentPage: this.current_page,
            dataLastPage: this.last_page
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
        changeSelect() {
            this.$emit('onChangePaginate', this.dataPaginate);
        },

        loadPage(page) {
            this.$emit('onLoadAnotherPage', page);
        }
    }
};
</script>

<style scoped>
    .pages {
        font-size: 1.1rem;
    }

    .page-item {
        width: 50px;
        height: 50px;
        cursor: pointer;
    }

    .page-item:hover {
        font-weight: bold;
    }

    .active-page {
        font-weight: bold;
        border-radius: 50px;
        color: white;
        background-color: #00aae9;
        border: none;
        outline: none;
        padding: 5px 12px;
    }
</style>