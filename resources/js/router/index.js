import Vue from 'vue'
import VueRouter from 'vue-router'
import reporteCertificadoOrigen from '../reporteCertificadoOrigen/router'
import reporteArticulos from '../reporteArticulos/router'
import { concat } from 'lodash'


Vue.use(VueRouter)

const reportes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('../Home.vue'),
        meta: {
            title: 'Inicio',
        },
        children: concat(reporteCertificadoOrigen,reporteArticulos)
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
