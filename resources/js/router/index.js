import Vue from 'vue'
import VueRouter from 'vue-router'
import certidicadoOrigen from '../reporteCertificadoOrigen/router'

Vue.use(VueRouter)

const reportes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../Home.vue'),
        meta: {
            title: 'Inicio',
        },
        children: (certidicadoOrigen)
    }, {
        name: 'notfoundcomponent',
        path: '*',
        component: () => import('../views/NotFoundComponent.vue'),
        meta: {
            title: 'No Encontrado',
        }
    }
]
const routes = (reportes)
var router = new VueRouter({
    mode: 'history',
    routes
})

export default router
