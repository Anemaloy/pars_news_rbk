<template>
    <div>
        <div class="row" v-for="(article, key) in articles" :key="key">
            <div class="col-md-12">
                <h2>{{ article.title }}</h2>
                <p v-html="article.content.substr(0, 200)"></p>
                <p><router-link :to="{ name: 'article', params: { articleId: article.id }}" class="btn btn-secondary" href="#" role="button">Подробнее »</router-link></p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
            }
        },
        props: ['articles']
    }
</script>
