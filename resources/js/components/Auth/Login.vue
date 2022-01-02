
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
                            <h1 class="h4 text-gray-900 mb-4">Login</h1>
                        </div>
                                <form class="user" @submit.prevent="login">
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
                                    <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">Remember
                                        Me</label>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block loginbtn">Login</button>
                                    </div>
                                    <hr>

                                </form>
                                
                                <div class="text-center">
                                    <router-link :to="{ name: 'register'}" class="font-weight-bold small">Create an Account!</router-link>
                                </div>
                                <div class="text-center">
                                    <router-link :to="{ name: 'reset'}" class="font-weight-bold small">Reset Password</router-link>
                                </div>                        

                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end base div -->
</template>

<script>
export default{
    created(){
        if(User.loggedIn()){
            this.$router.push({ name : 'home'})
        }
        console.log(this.$route.path);
    },
    data(){
        return {
            form : {
                email : null,
                password: null
           },
           errors:{}
        }
    },
    methods: {
        login(){
            let loginBtn = document.querySelector('.loginbtn');
            loginBtn.innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:15px"></i> Loading....';
            console.log('hey i got to level 1');
            axios.post(globalURL+'/api/auth/login',this.form)
            .then(res => {
                User.responseAfterLogin(res)                            
                Toast.fire({
                    icon: 'success',
                    title: 'Signed in successfully'
                });

                this.$router.push({ name : 'home'});
                loginBtn.innerHTML = 'Login'; 
                console.log('hey i got to level 2');
            })
            .catch((error) => {
                // this.errors = error.response.data.errors;
                console.log(error);
                Toast.fire({
                    icon: 'warning',
                    title: 'Invalid Email or Password'
                });
                loginBtn.innerHTML = 'Login';
                console.log('hey i got to level 3');   
            })
        }
    }
}

</script>


<style scoped>

</style>