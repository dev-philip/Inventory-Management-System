
<template>
<!-- start base div -->
    <div>
        <div class="row">
            <router-link :to="{ name: 'category'}" class="btn btn-primary">All Category</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Add Category</h1>
                        </div>
                        <form class="user" @submit.prevent="categoryInsert">

                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Your Category Name" v-model="form.category_name">
                                        <small class="text-danger" v-if="errors.category_name">{{ errors.category_name[0] }}</small>
                                    </div>

                                </div>
                            </div>

                                                                

                            <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>

                        </form>
 
                    </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        
    </div>
<!-- end of base div -->
</template>

<script>
export default{
    created(){
        if(!User.loggedIn()){
            this.$router.push({ name : 'home'})
        }

    },
    data(){
        return {
            form : {
                category_name: null,
           },
           errors:{}
        }
    },
    methods: {

        categoryInsert(){
            axios.post(globalURL+'/api/category', this.form)
            .then((response) => {
                console.log(response);
                console.log('Supplier Api Successful');
                this.$router.push({name: 'category'})
                Notification.success()
            })
            .catch((error) => {
                this.errors = error.response.data.errors;
                console.log(this.errors);
                console.log('Supplier Api Error Occured');
              });
        },
    }
}

</script>


<style scoped>

</style>