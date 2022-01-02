
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
                            <h1 class="h4 text-gray-900 mb-4">Register</h1>
                        </div>
                        <form class="user" @submit.prevent="signup">
                            <div class="form-group">
                            <input type="text" class="form-control" id="exampleInputFirstName" placeholder="Enter Full Name" v-model="form.name" required>
                            <small class="text-danger" v-if="errors.name">{{ errors.name[0] }}</small>
                            </div>

                            <div class="form-group">
                            <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Enter Email Address" v-model="form.email" required>
                                <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                            </div>

                            <div class="form-group">
                            <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password" v-model="form.password" required>
                            <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                            </div>

                            <div class="form-group">
                            <input type="password" class="form-control" id="exampleInputPasswordRepeat"
                                placeholder="Confirm Password" v-model="form.password_confirmation" required>
                            </div>

                            <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block signupbtn">Register</button>
                            </div>
                            <hr>

                        </form>
                      
                        <div class="text-center">
                           <router-link :to="{ name: '/'}" class="font-weight-bold small">Already have an account?</router-link>
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
                name: null,
                email : null,
                password: null,
                confirm_password: null
           },
           errors:{}
        }
    },
    methods: {
        signup(){
            let signupBtn = document.querySelector('.signupbtn');
            signupBtn.innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:15px"></i> Loading....';

            axios.post(globalURL+'/api/auth/signup',this.form)
            .then(res => {
                User.responseAfterLogin(res)                            
                Toast.fire({
                    icon: 'success',
                    title: 'Signed in successfully'
                });

                this.$router.push({ name : 'home'});
                signupBtn.innerHTML = 'Register';  
            })
            .catch((error) => {
                this.errors = error.response.data.errors;
                signupBtn.innerHTML = 'Register'; 
            });
        }
    }
}

</script>


<style scoped>

</style>