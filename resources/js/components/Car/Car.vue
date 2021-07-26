<template>
    <div class="grid grid-cols-12 col-gap-1 mt-6">
        <div class="col-span-2 auto-rows-max">
            <fieldset>
                <div class="mt-4 space-y-4">
                    <legend class="text-base font-medium text-gray-900">Type</legend>
                    <div class="flex items-start" v-for="(filter, index) in filters.body" :key="'filter_body'+index">
                        <div class="flex items-center h-5">
                            <input :id="'filter_body'+index" :value="filter.body_type" v-model="selects.body" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label :for="'filter_body'+index" class="font-medium text-gray-700">{{filter.body_type}}</label>
                        </div>
                    </div> 

                    <legend class="text-base font-medium text-gray-900">Fuel</legend>
                    <div class="flex items-start" v-for="(filter, index) in filters.fuel" :key="'filter_fuel'+index">
                        <div class="flex items-center h-5">
                            <input :id="'filter_fuel'+index" :value="filter.fuel_type" v-model="selects.fuel" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label :for="'filter_fuel'+index" class="font-medium text-gray-700">{{filter.fuel_type}}</label>
                        </div>
                    </div>

                    <legend class="text-base font-medium text-gray-900">Transmission</legend>
                    <div class="flex items-start" v-for="(filter, index) in filters.transmission" :key="'filter_transmission'+index">
                        <div class="flex items-center h-5">
                            <input :id="'filter_transmission'+index" :value="filter.transmission_type" v-model="selects.transmission" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm">
                            <label :for="'filter_transmission'+index" class="font-medium text-gray-700">{{filter.transmission_type}}</label>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-span-9 col-start-4 grid grid-cols-10 auto-rows-max">
            <div class="col-span-3 p-4 w-full overflow-hidden" v-for="item in cars.data" :key=item.id>
                <div class="bg-gray-100 shadow-lg rounded overflow-hidden">
                    <div>
                        <img src="http://unsplash.it/400/300" alt="Placeholder" class="w-full h-full object-cover object-center" />
                    </div>
                    <div class="p-4">
                        <router-link class="mr-4" :to="{ name: 'CarShow', params: { id: item.id }}">
                            <h5 class="text-2xl">{{item.make +' '+ item.model}}</h5>
                        </router-link> 
                        <p class="my-1">Year: {{item.year}}</p>
                        <p class="my-1">Price: {{formatPrice(item.price)}} $</p>
                        <p class="my-1">Type: {{item.body_type}}</p>
                        <p class="my-1">Fuel: {{item.fuel_type}}</p>
                        <p class="my-1">Transmission: {{item.transmission_type}}</p>
                    </div>
                </div>
            </div>
            <div class="col-span-9 row-span-1 row-end-5 overflow-hidden">
                <tailable-pagination :data="cars"  @page-changed="loadCars" :showNumbers="true" :hide-when-empty="true"></tailable-pagination>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            filters: {},
            selects: {
                body: [],
                fuel: [],
                transmission: []
            },
            cars: {},
        }
    },
    mounted(){
        this.loadCars();
        this.getFilters();
    },
    watch:{
        selects:{
            handler: function(){
                this.loadCars();
            },
            deep: true
        }
    },
    methods:{
        loadCars(page=1){
            axios.post(`/api/load-cars?page=${page}`, this.selects).then((res) => {
                this.cars = res.data;
            });
        },
        getFilters(){
            axios.get('/api/get-filters').then((res) =>{
                this.filters = res.data;
            });
        },
        formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        }
    }
}
</script>

<style>

</style>