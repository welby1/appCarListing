import Home from './components/Home';
import Car from './components/Car/Car';
import Register from './components/Register';
import Login from './components/Login';
import Dashboard from './components/Dashboard';
import NotFound from './components/NotFound';
import CarShow from './components/Car/Show';


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