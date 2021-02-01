<template>
    <div  class="container">
        <button @click="fetchAllArticles()">test</button>
        <pars-button @loaded="fetchAllArticles()"></pars-button>
        <ul v-if="articles.length > 0">
            <li v-for="(article, key) in articles">{{article.title}}</li>
        </ul>
        <p v-else> Новостей нет. Попробуйте загрузить</p>
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
