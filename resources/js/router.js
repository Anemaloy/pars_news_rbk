import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const router = new Router({
  mode: 'history',
  base: '/',
  routes: [
    {
      path: '',
      component: () => import('./pages/articles/index.vue'),
    },
    {
        path: '/:articleId',
        name: 'article',
        component: () => import('./pages/articles/show.vue'),
    },
    // Redirect to 404 page, if no match found
    {
      path: '*',
      redirect: '/pages/error-404'
    }
  ]
})

export default router
