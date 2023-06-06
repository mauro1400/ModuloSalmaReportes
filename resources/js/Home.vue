<template>
    <div>
        <Navbar>
        </Navbar>
        <router-view>
        </router-view>
    </div>
</template>
<script>

const Navbar = () => import(/* webpackChunkName: "Navbar" */ './layouts/navbar.vue')

export default {
    components: {
        Navbar,
    },
    data() {
        return {};
    },
}
</script>