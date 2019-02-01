import Vue from 'vue'
import VueRouter from 'vue-router'

import Task from '../components/Task.vue'
import Profile from '../components/Profile.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        { path: '/', component: Task },
        { path: '/profile', component: Profile }
    ],
    mode: 'history'
})

export default router