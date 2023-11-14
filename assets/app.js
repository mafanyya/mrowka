import './bootstrap.js';

import './styles/app.css';

import {registerVueControllerComponents } from '@symfony/ux-vue';
import RegisterForm from "./vue/controllers/RegisterForm.vue";
import Home from "./vue/controllers/Home.vue";

registerVueControllerComponents(require.context('./vue/controllers', true, /\.vue$/));
document.addEventListener('vue:before-mount', (event) => {
    const {
        componentName, // The Vue component's name
        component, // The resolved Vue component
        props, // The props that will be injected to the component
        app, // The Vue application instance
    } = event.detail;

    const router = VueRouter.createRouter({
        history: VueRouter.createWebHashHistory(),
        routes: [
            {path: '/register', component: RegisterForm},
            {path: '/', component: Home}
        ],
    });
    app.use(router);
});

