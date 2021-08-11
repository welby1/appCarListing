<template>
  <div class="mt-10 sm:mt-0">
  <div class="md:grid md:grid-cols-1">
    <div class="mt-5 md:mt-0 md:col-span-2">
      <form method="POST">
        <div class="shadow overflow-hidden sm:rounded-md">
          <div class="px-4 py-5 bg-white sm:p-6">
            <div class="grid grid-cols-6 gap-6">    

              <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                <label for="make" class="block text-sm font-medium text-gray-700">Make</label>
                <input type="text" v-model="form.make" name="make" id="make" class="py-2.5 pl-3 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
              <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                <input type="text" v-model="form.model" name="model" id="model" class="py-2.5 pl-3 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
              <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                <label for="year" class="block text-sm font-medium text-gray-700">Year</label>
                <input type="text" v-model="form.year" name="year" id="year" class="py-2.5 pl-3 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>

              <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                <label for="body_type" class="block text-sm font-medium text-gray-700">Body Type</label>
                <input type="text" v-model="form.body_type" name="body_type" id="body_type" class="py-2.5 pl-3 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
              <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                <label for="fuel_type" class="block text-sm font-medium text-gray-700">Fuel Type</label>
                <input type="text" v-model="form.fuel_type" name="fuel_type" id="fuel_type" class="py-2.5 pl-3 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
              <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                <label for="engine_displ" class="block text-sm font-medium text-gray-700">Engine Displacement</label>
                <input type="text" v-model="form.engine_displ" name="engine_displ" id="engine_displ" class="py-2.5 pl-3 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>

              <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                <label for="transmission_type" class="block text-sm font-medium text-gray-700">Transmission</label>
                <input type="text" v-model="form.transmission_type" name="transmission_type" id="transmission_type" class="py-2.5 pl-3 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
              <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="text" v-model="form.price" name="price" id="price" class="py-2.5 pl-3 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
              </div>
              <div class="col-span-12 sm:col-span-12 lg:col-span-6">
                  <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                  <div class="mt-1">
                      <textarea  v-model="form.description" id="description" name="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                  </div>
              </div>
            
            </div>
          </div>
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
            <button @click.prevent="createCar" type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Save
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</template>

<script>
export default {
data(){
        return{
            form:{
                make: '',
                model: '',
                year: '',
                body_type: '',
                fuel_type: '',
                engine_displ: '',
                transmission_type: '',
                price: '',
                description: ''
            },
        }
    },
    methods:{
        createCar(){
            axios.post('/api/cars', this.form).then((res) => {
                console.log(res.data);
                this.$router.push({ name: 'Dashboard' });
            });
        }
    }
}
</script>

<style>

</style>