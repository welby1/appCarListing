<template>
    <div>
        <div class="flex bg-gray-100 border-b border-gray-300 py-4">
            <div class="container mx-auto flex justify-between">
                <div class="flex">
                    <router-link class="mr-4" to='/' exact>Home</router-link>
                    <router-link class="mr-4" to='/cars'>Cars</router-link>
                    <router-link class="mr-4" to='/dashboard'>Dashboard</router-link>
                    <router-link class="mr-4" to='/message'>Chat</router-link>
                </div>
                <div class="flex">
                    <router-link v-if="auth==0" class="mr-4" to='/login' exact>Login</router-link>
                    <router-link v-if="auth==0" class="mr-4" to='/register'>Register</router-link>
                    <div v-if="auth==1">
                        <div class="dropdown inline-block relative">
                            <button class="text-gray-700 py-1 px-4 rounded inline-flex items-center">
                                <span class="mr-1">{{ user.email }}</span>
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/> </svg>
                            </button>
                            <ul class="dropdown-menu absolute hidden text-gray-700 pt-1">
                                <li><a @click.prevent="logout" class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" href='/logout'>Logout</a></li>
                                <li>
                                    <router-link class="rounded-t bg-gray-200 hover:bg-gray-400 py-2 px-4 block whitespace-no-wrap" :to="{ name: 'MyMessages', params: { userId: this.userId }}">
                                        Messages
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <content-view></content-view>
    </div>
</template>

<script>
export default{
    data(){
        return{
            auth: 0,
            user: '',
            userId: ''
        }
    },
    mounted(){
        this.checkAuth();

        axios.get('/api/user').then((response)=>{
            this.user = response.data;
            this.userId = response.data.id
        });
    },
    methods:{
         checkAuth(){
             axios.get('/api/authenticated').then(() =>{
                 this.auth = 1; 
             });
         },
         // should be used Vuex :)
         logout(){
            axios.post('/api/logout').then(()=>{
                this.$router.push({ name: "Home"})
            })
        },
    }
} 
</script>

<style>
.dropdown:hover .dropdown-menu {
  display: block;
}
</style>