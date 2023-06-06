import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
const home = [
    {
        path: '/home',
        name: 'home',
        component: () => import('../home.vue'),
        meta: {
            title: 'Inicio',
            //requiresAuth: true,
            //middleware: 'auth',
        },
        //children: auth.concat(estudiante, usuario, chofer, apoderado, transporte)
    }, {
        name: 'notfoundcomponent',
        path: '*',
        component: () => import('../views/NotFoundComponent.vue'),
        meta: {
            title: 'No Encontrado',
        }
    }
]
//const routes = auth.concat(home)
var router = new VueRouter({
    mode: 'history',
    home
})

export default router
