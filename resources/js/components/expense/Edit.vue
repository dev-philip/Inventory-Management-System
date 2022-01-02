
<template>
<!-- start base div -->
    <div>
        <div class="row">
            <router-link :to="{ name: 'expense'}" class="btn btn-primary">All Expenses</router-link>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Edit Expenses</h1>
                        </div>
                        <form class="user" @submit.prevent="expenseUpdate">

                            <div class="form-group">
                             
                                    <div class="col-md-12">
                                        <label for="exampleFormControlTextarea1"><b>Expense Details</b></label>
                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="form.details"></textarea>
                                        <small class="text-danger" v-if="errors.details">{{ errors.details[0] }}</small>
                                    </div>
                                    
                                    <br>
                                    <div class="col-md-12">
                                        <label for="exampleFormControlTextarea1"><b>Expense Amount</b></label>
                                        <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Your Amount" v-model="form.amount">
                                        <small class="text-danger" v-if="errors.amount">{{ errors.amount[0] }}</small>
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
                details: null,
                amount: null,
                },
           errors:{}
        }
    },
    created(){
        let id = this.$route.params.id;
        axios.get(globalURL+'/api/expense/'+id)
        .then(({data}) => (this.form = data))
        .catch(console.log('error'));
    },
    methods: {
        expenseUpdate(){
            let id = this.$route.params.id;
            axios.patch(globalURL+'/api/expense/'+id, this.form)
            .then(() => {
                this.$router.push({name: 'expense'})
                Notification.success()
            })
            .catch(error => this.errors = error.response.data.errors)
        }
    }
}

</script>


<style scoped>

</style>