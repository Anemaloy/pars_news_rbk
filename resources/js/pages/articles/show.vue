<template>
    <div class="row" v-if="article">
        <h1>{{ article.title }}</h1>
        <p v-html="article.content"></p>
    </div>
</template>

<script>

    export default {
        data () {
            return {
                article: null
            }
        },
       created() {
           this.fetch_data(this.$route.params.articleId)
       },
        methods: {
            fetch_data(id){
                let vm = this;
                axios.get('/api' + this.$root.$api.Articles.get + id)
                    .then((response) => {
                       vm.article = response.data;
                    })
            }
        }
    }
</script>
