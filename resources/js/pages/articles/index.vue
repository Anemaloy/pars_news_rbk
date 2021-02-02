<template>
    <div>
        <div class="row mb-5 mt-2">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <pars-button @loaded="fetchAllArticles()"></pars-button>
            </div>
        </div>
        <template v-if="articles.length > 0" >
            <articles-block :articles="articles"></articles-block>
        </template>
        <p v-else> Новостей нет. Попробуйте загрузить</p>
    </div>
</template>

<script>
    import parsButton  from './../../components/Loader.vue'
    import articlesBlock  from './../../components/Article.vue'

    export default {
        data () {
            return {
                articles: [],
            }
        },
        components: {
            parsButton,
            articlesBlock
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
