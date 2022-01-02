
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
                            <h1 class="h4 text-gray-900 mb-4">Forget Password</h1>
                        </div>
                                <form class="user" @submit.prevent="forget">
                                    <div class="form-group">
                                    <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Enter Email Address" v-model="form.email" required>
                                        <small class="text-danger" v-if="errors.email">{{ errors.email[0] }}</small>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block forgetbtn">Forget Password</button>
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
    <!-- end base div -->
</template>

<script>
export default{
    data(){
        return {
            form : {
                email : null,
                forgetPassword : null,
           },
           errors:{}
        }
    },
    methods: {
        forget(){
            let forgetBtn = document.querySelector('.forgetbtn');
            forgetBtn.innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:15px"></i>';
            // alert(this.form.email);

            axios.get(globalURL+'/api/auth/forget/' + this.form.email)
            .then((data) => {
                this.form.forgetPassword = data.data;

                //START
                Swal.fire({
                html: "<h5>Your Passowrd is <b style='color:#3fc3ee;'>" +this.form.forgetPassword+"</b></h5>",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Got It',
                confirmButtonText: 'Reset Password'
                }).then((result) => {
                if (result.isConfirmed) {
                    this.$router.push({ name : 'reset'})
                }
                })
                //END
                forgetBtn.innerHTML = 'Forget Password';
                // console.log(this.form.forgetPassword);
            })
            .catch((error) => {
                forgetBtn.innerHTML = 'Forget Password';
                Toast.fire({
                    icon: 'warning',
                    title: 'Invalid Email'
                })  
            })

        }
    }
}

</script>


<style scoped>

</style>