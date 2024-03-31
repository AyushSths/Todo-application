import { createRouter, createWebHistory } from 'vue-router'

import Register from '../components/Register.vue';
import Login from '../components/Login.vue';
import Home from '../components/Home.vue';
import Tasks from '../components/Tasks.vue';
import UserManagement from "../components/UserManagement.vue";

const routes = [

    {
        path: '/',
        name: 'HomePage',
        component: Home
    },
    {
        path: '/register',
        name: 'RegisterPage',
        component: Register
    },
    {
        path: '/login',
        name: 'LoginPage',
        component: Login
    },
    {
        path: '/todos',
        name: 'TasksPage',
        component: Tasks
    },
    {
        path: '/userManagement',
        name: 'userManagement',
        component: UserManagement
    },
]

const router = createRouter({ history: createWebHistory(process.env.BASE_URL), routes })

export default router