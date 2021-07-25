<template>
    <div>
        Dashboard
        <br>
        <div v-if="user">
            Name: {{user.name}} <br>
            Email: {{user.email}}<br><br>
            <button @click.prevent="logout">Logout</button>
        </div>

        <div>     
            <a v-for="car in cars" :key=car.id>{{car.make}}</a>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            user: null,
            cars:[]
        }
    },
    methods:{
        logout(){
            axios.post('/api/logout').then(()=>{
                this.$router.push({ name: "Home"})
            })
        },
        carList(){
            axios.get('/api/cars')
                .then((res) => {
                    this.cars = res.data;
                });
        }
    },
    mounted(){
        axios.get('/api/user').then((response)=>{
            this.user = response.data
        });
        this.carList();
    }
}
</script>

<style>

</style>