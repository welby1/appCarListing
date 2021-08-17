<template>
    <div class="col-span-3 col-start-10 -mt-6">
        <h2 class="text-center text-2xl">Latest Deals</h2>
        <div class="col-span-3 grid grid-cols-1 grid-rows-4 gap-4 p-2 bg-gray-200 rounded">
            <div v-for="car in cars" :key=car.id class="col-span-1 row-span-1 rounded overflow-hidden">
                <p :key=car.id>{{ car.make }} {{ car.model }}</p>
                <img v-for="img in car.photos" :key=img.id :src="img.img_path" alt="Placeholder" class="w-full object-cover object-center" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            cars: [],
        }
    },
    mounted(){
        this.latestDeals();

        Echo.channel('car-created-channel')
            .listen('CarCreated', (event) => {
                //console.log(event.message);
                this.latestDeals();
            });
    },
    methods:{
         latestDeals(){
             axios.get('/api/latest-deals').then((res) =>{
                 this.cars = res.data; 
             });
         },
    }
}
</script>

<style>

</style>