<template>
    <div class="container">
        <router-view />
    </div>
</template>

<script>
    import parsButton  from './../components/Loader.vue'

    export default {
        data () {
            return {
                articles: [],
            }
        },
        components: {
            parsButton
        },
        created() {
            this.fetchAllArticles();
        },
        methods: {
            fetchAllArticles() {
                let vm = this;
                axios.get('/api' + this.$root.$api.Articles.load)
                    .then((response) => {
                        vm.articles = response.data;
                    })
            }
        },
    }
</script>
