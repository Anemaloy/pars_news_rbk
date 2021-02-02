<template>
    <div  class="container">
        <pars-button @loaded="fetchAllArticles()"></pars-button>
        <template v-if="articles.length > 0" >
            <articles-block :articles="articles"></articles-block>
        </template>
        <p v-else> Новостей нет. Попробуйте загрузить</p>
    </div>
</template>

<script>
    import parsButton  from './../components/Loader.vue'
    import articlesBlock  from './../components/Article.vue'

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
