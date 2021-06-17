import TodoList from './components/TodoList';
import Login from './components/Login';
import Register from './components/Register';
import CreateTodo from './components/CreateTodo';
import ViewTodo from './components/ViewTodo';
import PageNotFound from './components/PageNotFound';

export default{
    mode: 'history',
    linkActiveClass: 'font-semibold',
    routes:[
        {
            path: '*',
            component: PageNotFound
        },
        {
            path: '/',
            component: TodoList
        },
        // {
        //     path: '/my-todo-list',
        //     path: MyTodoList
        // },
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
            component: CreateTodo
        },
        {
            path: '/view-todo',
            component: ViewTodo
        }
    ]
}