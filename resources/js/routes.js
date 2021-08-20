import Home from './components/Home';
import Car from './components/Car/Car';
import Register from './components/Register';
import Login from './components/Login';
import Dashboard from './components/Dashboard';
import NotFound from './components/NotFound';
import CarShow from './components/Car/Show';
import CarCreate from './components/Car/Create';
import Chat from './components/Chat/Chat';
import PrivateMessage from './components/PrivateMessage/Message';
import MyMessages from './components/PrivateMessage/MyMessages';
import MyMessage from './components/PrivateMessage/MyMessage';


export default{
    mode: 'history',
    linkActiveClass: 'font-semibold',
    routes: [
        {
            path: '*',
            component: NotFound
        },
        {
            path: '/',
            component: Home,
            name: "Home"
        },
        {
            path: '/cars',
            component: Car
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: '/login',
            component: Login,
            name: 'Login'
        },
        {
            path: '/api/cars/:id',
            component: CarShow,
            name: 'CarShow'
        },
        {
            path: '/api/cars/create',
            component: CarCreate,
            name: 'CarCreate'
        },
        {
            path: '/message',
            component: Chat,
            name: 'Chat',
            beforeEnter: (to, form, next) =>{
                axios.get('/api/authenticated')
                .then(()=>{
                    next();
                }).catch(()=>{
                    return next({ name: 'Login'});
                })
            }
        },
        {
            path: '/message/from/:from/to/:to/car/:car',
            component: PrivateMessage,
            name: 'PrivateMessage'
        },
        {
            path: '/my/messages',
            component: MyMessages,
            name: 'MyMessages'
        },
        {
            path: '/my/message/:conversation/:sender/:recipient/:subject',
            component: MyMessage,
            name: 'MyMessage'
        },
        {
            path: "/dashboard",
            name: "Dashboard",
            component: Dashboard,
            beforeEnter: (to, form, next) =>{
                axios.get('/api/authenticated')
                .then(()=>{
                    next();
                }).catch(()=>{
                    return next({ name: 'Login'});
                })
            }
       
          }
          
    ]
}