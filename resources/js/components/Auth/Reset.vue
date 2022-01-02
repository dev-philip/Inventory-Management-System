
<template>
<!-- start base div -->
    <div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Reset Password</h1>
                        </div>
                        <form class="user" @submit.prevent="signup">

                            <div class="form-group">
                            <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Enter Email Address" v-model="form.email" required>
                                <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                            </div>

                            <div class="form-group">
                            <input type="password" class="form-control" id="exampleInputPassword" placeholder="Enter New Password" v-model="form.password" required>
                            <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                            </div>

                            <div class="form-group">
                            <input type="password" class="form-control" id="exampleInputPasswordRepeat"
                                placeholder="Enter Confirm Password" v-model="form.password_confirmation" required>
                            </div>

                            <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block resetbtn">Reset</button>
                            </div>
                            <hr>

                        </form>
                      
                        <div class="text-center">
                           <router-link :to="{ name: '/'}" class="font-weight-bold small">Back to Login!</router-link>
                        </div>
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
        if(User.loggedIn()){
            this.$router.push({ name : 'home'})
        }

    },
    data(){
        return {
            form : {
                email : null,
                password: null,
                password_confirmation: null
           },
           errors:{}
        }
    },
    methods: {
        signup(){
            let forgetBtn = document.querySelector('.resetbtn');
            forgetBtn.innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:15px"></i> Loading....';
            console.log('hey i got to level 1');
            axios.post(globalURL+'/api/auth/reset', this.form)
            .then((data) => {
                console.log('hey i got to level 2');
                
                if(data.data.status == 'true'){
                    Toast.fire({
                    icon: 'success',
                    title: 'Password Updated Successfully'
                });

                    this.$router.push({ name : '/'})
                    console.log('hey i got to level 3');
                }
                
                if(data.data.status == 'false'){
                    Toast.fire({
                        icon: 'warning',
                        title: 'Invalid Email'
                    });
                    console.log('hey i got to level 4');
                }     
                forgetBtn.innerHTML = 'Reset';                   
                console.log('hey i got to level 5');
            })
            .catch((error) => {
                forgetBtn.innerHTML = 'Reset';  
                console.log(error); 
                // this.errors = error.response.data.errors;
                console.log('hey i got to level 6');
            })
        }
    }
}

</script>


<style scoped>

</style>