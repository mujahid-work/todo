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
            component: PageNotFound,
            name: '404'
        },
        {
            path: '/',
            component: TodoList,
            name: 'list'
        },
        {
            path: '/verify-account',
            component: VerifyAccount,
            name: 'verify'
        },
        {
            path: '/login',
            component: Login,
            name: 'login'
        },
        {
            path: '/register',
            component: Register,
            name: 'register'
        },
        {
            path: '/create-todo',
            component: CreateTodo,
            name: 'create',
            beforeEnter: (to, from, next) => {
                axios.get('api/authenticated').then((res) => {
                    if (res.data == 1) {
                        next();
                    }
                    else {
                        next({ name: "login" })
                    }
                }).catch(() => {
                    return next({ name: "login" })
                })
            }
        },
        {
            path: '/view-todo/:id',
            component: ViewTodo,
            name: 'view',
            beforeEnter: (to, from, next) => {
                axios.get('api/authenticated').then((res) => {
                    if (res.data == 1) {
                        next();
                    }
                    else {
                        next({ name: "login" })
                    }
                }).catch(() => {
                    return next({ name: "login" })
                })
            }
        }
    ]
}