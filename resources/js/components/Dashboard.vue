<template>
    <div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">Car</div>
                                <div class="ml-4">
                                    <button type="submit" class="py-0 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2">
                                        <router-link :to="{ name: 'CarCreate' }">New</router-link>
                                    </button>
                                </div>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="car in cars" :key=car.id>
                        <td class="px-6 py-1 whitespace-nowrap">
                            <div class="flex items-center">
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <router-link class="mr-4" :to="{ name: 'CarShow', params: { id: car.id }}">
                                        {{car.make +' '+ car.model}}
                                    </router-link> 
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{car.year}}
                                </div>
                            </div>
                            </div>
                        </td>
                        <td class="px-6 py-1 whitespace-nowrap text-right text-sm font-medium">
                            <div class="text-sm text-gray-900 py-1">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900 ">Edit</a>
                            </div>
                            <div class="text-sm text-gray-500 py-1">
                                <a href="#" class="text-red-600 hover:text-red-900 ">Delete</a>
                            </div>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                </div>
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
    methods:{
        userCarList(){
            axios.get('/api/cars')
                .then((res) => {
                    this.cars = res.data;
                });
        },
        addCar(){
            axios.get('/api/car/create');
        }
    },
    mounted(){
        this.userCarList();
    }
}
</script>

<style>

</style>