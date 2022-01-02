
<template>
<!-- start base div -->
    <div>
         <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">POS</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Area Chart -->
            <div class="col-xl-5 col-lg-5">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Expense Insert</h6>
                  <a class="btn btn-sm btn-info"><font color="#ffffff">Add Customer</font></a>
          
                </div>
           
                <div class="table-responsive" style="font-size: 12px;">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Total</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="cart in carts" :key="cart.id">
                        <td>{{ cart.pro_name }}</td>
                        <td>
                            <input type="text" readonly="" :value="cart.pro_quantity" style="width: 15px;">
                            <button @click.prevent="increment(cart.id)" class="btn btn-sm btn-success">+</button>
                            <button @click.prevent="decrement(cart.id)" v-if="cart.pro_quantity >= 2" class="btn btn-sm btn-danger">-</button>
                            <button @click.prevent="decrement(cart.id)" v-else class="btn btn-sm btn-danger" disabled><font color="#000000">-</font></button>
                        </td>
                        <td>{{ cart.pro_quantity }}</td>
                        <td>{{ cart.sub_total}}</td>
                        <td><a @click="removeItem(cart.id)" class="btn btn-sm btn-primary"><font color="#ffffff">X</font></a></td>
                      </tr>

                    </tbody>
                  </table>
                </div>
                <div class="card-footer">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Quantity: 
                            <strong>{{ qty }}</strong>
                        </li>

                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            Sub Total: 
                            <strong>${{ subtotal }}</strong>
                        </li>

                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            Vat: 
                            <strong>{{vats.vat}}%</strong>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total: 
                            <strong>${{ subtotal * vats.vat /100 + subtotal}}</strong>
                        </li>
                    </ul>

                    <br>

                    <form @submit.prevent="orderdone">
                        <label>Customer Name</label>
                        <select class="form-control" v-model="customer_id">
                            <option :value="customer.id" v-for="customer in customers" :key="customer.id">
                                {{customer.name}}
                            </option>
                        </select>
                        

                        <label>Pay</label>
                        <input type="text" class="form-control" required v-model="pay">

                        <label>Due</label>
                        <input type="text" class="form-control" required v-model="due">

                    
                        <label>Pay By</label>
                        <select class="form-control" v-model="payby">
                            <option value="HandCash">Hand Cash</option>
                            <option value="Cheaque">Cheaque</option>
                            <option value="GiftCard">Gift Card</option>
                        </select>

                        <br>
                        <button type="submit" class="btn btn-success">Submit</button>

                    </form>
                 
                </div>

            <!-- end of table -->
              </div>
            </div>
            <!-- Pie Chart -->
            <div class="col-xl-7 col-lg-7">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Products Sold</h6>
                </div>

                <!-- Category Product -->

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All Product</a>
                    </li>
                    <li class="nav-item" v-for="category in categories" :key="category.id">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false" @click="subproduct(category.id)">{{ category.category_name}}</a>
                    </li>
                  
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-body">
                            <input type="text" v-model="searchTerm" class="form-control" style="width: 100%; margin-bottom:5px;" placeholder="Search Product">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6"  v-for="product in filtersearch" :key="product.id">
                                    <button class="btn btn-sm" @click.prevent="AddToCart(product.id)">
                                        <div class="card" style="width: 8.5rem; margin-bottom:5px;">
                                            <img :src="product.image" class="card-img-top em_photo" id="em_photo" alt="Product Image">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ product.product_name }}</h6>
                                                <span class="badge badge-success" v-if="product.product_quantity >= 1">Available ({{ product.product_quantity}})</span>
                                                <span class="badge badge-danger" v-else>Out of Stock</span>
                                            </div>
                                        </div>
                                    </button>    
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <input type="text" v-model="getsearchTerm" class="form-control" style="width: 100%; margin-bottom:5px;" placeholder="Search Product">
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6"  v-for="getproduct in getfiltersearch" :key="getproduct.id">
                                    <button class="btn btn-sm" @click.prevent="AddToCart(getproduct.id)">
                                        <div class="card" style="width: 8.5rem; margin-bottom:5px;">
                                            <img :src="getproduct.image" class="card-img-top em_photo" id="em_photo" alt="Product Image">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ getproduct.product_name }}</h6>
                                                <span class="badge badge-success" v-if="getproduct.product_quantity >= 1">Available ({{ getproduct.product_quantity}})</span>
                                                <span class="badge badge-danger" v-else>Out of Stock</span>
                                            </div>
                                        </div>
                                    </button>    
                                </div>
                            </div>

                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
                </div>
                <!-- End Category Product -->


               
              </div>
            </div>
     
          </div>
          <!--Row-->

        </div>
        <!---Container Fluid-->
        
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
    created(){
        this.allProduct();
        this.allCategory();
        this.allCustomer();
        this.cartProduct();
        this.vat();

        Reload.$on('AfterAdd', () => {
            this.cartProduct();
        })
    },
    data(){
        return{
            customer_id: '',
            pay: '',
            due:'',
            payby: '',
            products:[],
            categories:'',
            getproducts:[],
            searchTerm: '',
            getsearchTerm: '',
            customers: '',
            errors: '',
            carts: [],
            vats: '',
        }
    },
    computed: {
      filtersearch(){
        return this.products.filter(product => {
          return product.product_name.match(this.getsearchTerm)
        })
      },
        getfiltersearch(){
        return this.getproducts.filter(getproduct => {
          return getproduct.product_name.match(this.searchTerm)
        })
      },
      qty(){
          let sum = 0;
          for(let i=0; i < this.carts.length; i++){
              sum += (parseFloat(this.carts[i].pro_quantity));
          }
          return sum;
      },
      subtotal(){
          let sum = 0;
          for(let i=0; i < this.carts.length; i++){
              sum += (parseFloat(this.carts[i].pro_quantity) * parseFloat(this.carts[i].product_price));
          }
          return sum;
      },
      
    },
    methods: {
        //Cart Methods Here
        AddToCart(id){
             axios.get(globalURL+'/api/addToCart/'+id)
            .then(() => {
                Reload.$emit('AfterAdd')
                Notification.cart_success()
            })
            .catch()
        },

        cartProduct(){
            axios.get(globalURL+'/api/cart/product/')
            .then(({data}) => (this.carts = data))
            .catch()
        },

        removeItem(id){
            axios.delete(globalURL+'/api/remove/cart/'+id)
            .then(() => {
                Reload.$emit('AfterAdd')
                Notification.cart_delete()
            })
            .catch()
        },
        increment(id){
             axios.get(globalURL+'/api/increment/'+id)
            .then(() => {
                Reload.$emit('AfterAdd')
                Notification.success()
            })
            .catch()
        },
        decrement(id){
             axios.get(globalURL+'/api/decrement/'+id)
            .then(() => {
                Reload.$emit('AfterAdd')
                Notification.success()
            })
            .catch()
        },
        vat(){
            axios.get(globalURL+'/api/vats/')
            .then(({data}) => (this.vats = data))
            .catch()
        },
        orderdone(){
            let total = this.subtotal *this.vats.vat /100 +this.subtotal;
            let data = {
                qty: this.qty,
                subtotal:this.subtotal,
                customer_id: this.customer_id,
                payby: this.payby,
                pay: this.pay,
                due: this.due,
                vat: this.vats.vat,
                total: total
            }
   
             axios.post(globalURL+'/api/orderdone', data)
            .then(() => {
                Notification.success()
                this.$router.push({name: 'home'})
            })
            
        },
        //End of Cart Methods
        allProduct(){
            axios.get(globalURL+'/api/product/')
            .then(({data}) => (this.products = data))
            .catch()
        },
        allCategory(){
            axios.get(globalURL+'/api/category/')
            .then(({data}) => (this.categories = data))
            .catch()
        },
        allCustomer(){
            axios.get(globalURL+'/api/customer/')
            .then(({data}) => (this.customers = data))
            .catch(console.log('error'))
        },
        subProduct(id){
            axios.get(globalURL+'/api/getting/product/'+id)
            .then(({data}) => (this.getproducts = data))
            .catch()
        }

        
    }
 
}

</script>


<style scoped>
.em_photo{
    height: 100px;
    width: 135px;
}

.card .table td,
.card .table th {
    padding-right: 0rem;
    padding-left: -1rem
}
</style>