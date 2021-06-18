import TodoList from './components/TodoList';
import Login from './components/Login';
import Register from './components/Register';
import CreateTodo from './components/CreateTodo';
import ViewTodo from './components/ViewTodo';
import PageNotFound from './components/PageNotFound';
import VerifyAccount from './components/VerifyAccount';
import axios from 'axios';

export default {
    mode: 'history',
    linkActiveClass: 'font-bold underline',
    routes: [
        {
            path: '*',
            component: PageNotFound
        },
        {
            path: '/',
            component: TodoList
        },
        {
            path: '/verify-account',
            component: VerifyAccount
        },
        {
            path: '/login',
            component: Login
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: '/create-todo',
            component: CreateTodo,
            beforeEnter: (to, from, next) => {
                axios.get('api/authenticated').then(() => {
                    next();
                }).catch(() => {
                    return next('/login')
                })
            }
        },
        {
            path: '/view-todo',
            component: ViewTodo,
            beforeEnter: (to, from, next) => {
                axios.get('api/authenticated').then(() => {
                    next();
                }).catch(() => {
                    return next('/login')
                })
            }
        }
    ]
}