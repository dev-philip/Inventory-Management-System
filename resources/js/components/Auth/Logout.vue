
<template>
    <!-- start base div -->
    <div>
        
    </div>
    <!-- end base div -->
</template>

<script>
    export default {
        created(){
            localStorage.removeItem('token');
            localStorage.removeItem('user');

            Toast.fire({
                    icon: 'success',
                    title: 'Logged Out successfully'
                });

            this.$router.push({ name : '/'})
        }
    }

</script>


<style scoped>

</style>