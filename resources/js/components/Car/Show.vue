<template>
<div>
    <div class="grid grid-cols-12 grid-rows-3 col-gap-1 mt-6" v-for="item in car.data" :key=item.id>
        <div class="col-span-5 row-span-2 p-4 w-full overflow-hidden">
            <h5 class="text-2xl">{{item.make +' '+ item.model}}</h5>
            <div class="bg-gray-100 shadow-lg rounded overflow-hidden" >
                <img v-for="img in item.photos" :key=img.id :src="img.img_path" alt="Placeholder" class="w-full h-full object-cover object-center" />
            </div>
        </div>
        <div class="col-span-5 row-span-2 p-4 w-full">
            <div class="p-4" >
                <h5 class="text-2xl">Dealer Info:</h5>
                <p class="my-1">Name: {{item.user.name}}</p>
                <p class="my-1">Email: {{(item.user.email)}}</p>
                <p class="my-1">Phone: {{item.user.phone_number}}</p>
                <router-link v-if="getUserData.id != item.user.id" class="mt-2" :to="{ name: 'PrivateMessage', params: { from: getUserData.id, to: item.user.id, car: item.id }}">
                    <h5 class="text-xl">Send Message</h5>
                </router-link> 
            </div>
        </div>
        <div class="grid grid-cols-2 col-span-5 row-start-3 row-span-1 p-4 w-full overflow-hidden">
            <div class="p-4">
                <p class="my-1">Year: {{item.year}}</p>
                <p class="my-1">Price: {{formatPrice(item.price)}} $</p>
                <p class="my-1">Engine: {{item.engine_displ}}</p>
            </div>
            <div class="p-4">
                <p class="my-1">Type: {{item.body_type}}</p>
                <p class="my-1">Fuel: {{item.fuel_type}}</p>
                <p class="my-1">Transmission: {{item.transmission_type}}</p>
            </div>
        </div>
    </div>
</div> 
</template>

<script>
import { mapGetters } from 'vuex'

export default {
    data(){
        return{
            car: [],
        }
    },
    mounted(){
        this.loadCar();
    },
    methods:{
        loadCar(){
            axios.get(`/api/cars/${this.$route.params.id}`).then((res) => {
                this.car = res.data;
            });
        },
        formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        }
    },
    computed:{
        ...mapGetters('user', ['getUserData'])
    },
}
</script>

<style>

</style>