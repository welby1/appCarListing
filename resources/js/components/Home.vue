<template>
    <div>
        <div class="grid grid-cols-12 gap-0">
            <div class="col-span-2 sm:col-span-2">
                <select v-model="form.make" @change="loadModels" id="make" name="make" autocomplete="make" class="mt-1 block w-3/4 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" selected disabled hidden>Choose Make</option>
                    <option v-for="car in carMakers" :key=car.make :value="car.make">{{ car.make }}</option>
                </select>
            </div>
            <div class="col-span-2 sm:col-span-2">
                <select v-model="form.model" id="model" name="model" :disabled="disabled == 1" autocomplete="model" class="mt-1 block w-3/4 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option v-if="disabled==0" value="" selected disabled hidden>Choose Model</option>
                    <option v-for="car in carModels" :key=car.model :value="car.model">{{ car.model }}</option>
                </select>
            </div>
            <div class="col-span-2 sm:col-span-2">
                <select v-model="form.year" id="year" name="year" autocomplete="year" class="mt-1 block w-3/4 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" selected disabled hidden>Choose Year</option>
                    <option v-for="car in carYears" :key=car.year :value="car.year">{{ car.year }}</option>
                </select>
            </div>
            <div class="mt-1">
                <button @click.prevent="searchCars" type="submit" class=" py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2">
                    Find
                </button>
            </div>
        </div>

        <div class="grid grid-cols-12 col-gap-1 mt-6">
            <div class="col-span-8 grid grid-cols-10 auto-rows-max">
                <div class="col-span-3 p-4 w-full overflow-hidden" v-for="item in searchResult.data" :key=item.id>
                    <div class="bg-gray-100 shadow-lg rounded overflow-hidden">
                        <div>
                            <img src="http://unsplash.it/400/300" alt="Placeholder" class="w-full h-full object-cover object-center" />
                        </div>
                        <div class="p-4">
                            <h5 class="text-2xl">{{item.make +' '+ item.model}}</h5>
                            <p class="my-1">Year: {{item.year}}</p>
                            <p class="my-1">Price: {{formatPrice(item.price)}} $</p>
                        </div>
                    </div>
                </div>
                <div class="col-span-9 row-span-1 row-end-5 overflow-hidden">
                    <tailable-pagination :data="searchResult"  @page-changed="searchCars" :showNumbers="true" :hide-when-empty="true"></tailable-pagination>
                </div>
            </div>

            <latest-deals></latest-deals>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            auth: 0,
            disabled: 1,
            carData: [],
            searchResult:{
                type: Object,
                default:null
            },
            models: [],
            form:{
                make: '',
                model: '',
                year: ''
            },
        }
    },
    mounted(){
        this.checkAuth();
        this.dropdownData();
    },
    methods:{
        checkAuth(){
             axios.get('/api/authenticated').then(() =>{
                 this.auth = 1; 
             });
         },
         dropdownData(){
            axios.get('/api/dropdown-data').then((res) => {
                this.carData = res.data;
            });
        },
        loadModels(){
            axios.post('/api/load-models', this.form).then((res) => {
                this.models = res.data;
                this.disabled = 0;
            });
        },
        searchCars(page=1){
            axios.post(`/api/search-cars?page=${page}`, this.form).then((res) =>{
                this.searchResult = res.data;
            }).catch(({ response })=>{
                console.error(response)
            });
        },
        formatPrice(value) {
            let val = (value/1).toFixed(0).replace('.', ',')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")
        }
    },
    computed:{
        carMakers(){
            return _.uniqBy(this.carData.data, 'make');
        },
        carModels(){
            return _.uniqBy(this.models, 'model');
        },
        carYears(){
            return _.uniqBy(this.carData.data, 'year');
        }
    }
}
</script>

<style>
.pagination{
        margin-bottom: 0;
    }
</style>