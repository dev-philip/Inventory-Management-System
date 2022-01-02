<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="{{ asset(env('APP_URL').'/backend/img/logo/logo.png') }}" rel="icon">
  <title>Dev Philip Inventory System - Dashboard</title>
  <link rel="stylesheet" type="text/css" href="{{ asset(env('APP_URL').'/css/app.css') }}">
  <link href="{{ asset(env('APP_URL').'/backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset(env('APP_URL').'/backend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset(env('APP_URL').'/backend/css/ruang-admin.min.css') }}" rel="stylesheet">
</head>

<body id="page-top">
<div id="app">
    <div id="wrapper">
        <nav id="sidebar" v-show="$route.path === '/' || $route.path === '/register' || $route.path === '/reset' || $route.path === '/forget' ? false : true" style="display:none;">
          <!-- Sidebar -->
            <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="javascript:void(0)">
                        <div class="sidebar-brand-icon">
                            <img src="{{ asset(env('APP_URL').'/backend/img/logo/logo2.png') }}">
                        </div>
                        <div class="sidebar-brand-text mx-3">Dev Philip</div>
                    </a>
                    <hr class="sidebar-divider my-0">
                    <li class="nav-item active">
                        <router-link class="nav-link" :to="{ name: 'home'}">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span></router-link>
                    </li>

                    <li class="nav-item">
                        <b>
                            <router-link class="nav-link" :to="{ name: 'pos'}">
                            <i class="fas fa-cash-register"></i>
                            <span>Point of Sale</span></router-link>
                        </b>
                    </li>

                    <hr class="sidebar-divider">
                    <div class="sidebar-heading">
                        Features
                    </div>
                    <!-- employee side nav -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseBootstrap"
                        aria-expanded="true" aria-controls="collapseBootstrap">
                        <i class="fas fa-user"></i>
                        <span>Employee</span>
                        </a>
                        <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <router-link class="collapse-item" :to="{ name: 'store-employee'}">Add Employee</router-link>
                            <router-link class="collapse-item" :to="{ name: 'employee'}">All Employee</router-link>
                        </div>
                        </div>
                    </li>

                    <!-- supplier side nav -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseBootstrap1"
                        aria-expanded="true" aria-controls="collapseBootstrap1">
                        <i class="fas fa-truck"></i>
                        <span>Suppliers</span>
                        </a>
                        <div id="collapseBootstrap1" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                           
                            <router-link :to="{ name: 'store-supplier'}" class="collapse-item">Add Suppliers</router-link>
                            <router-link :to="{ name: 'supplier'}" class="collapse-item">All Suppliers</router-link>
                        </div>
                        </div>
                    </li>


                    <!-- categoryr side nav -->
                    <li class="nav-item">
                        <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseBootstrap2"
                        aria-expanded="true" aria-controls="collapseBootstrap2">
                        <i class="fas fa-box-open"></i>
                        <span>Category</span>
                        </a>
                        <div id="collapseBootstrap2" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                           
                            <router-link :to="{ name: 'store-category'}" class="collapse-item">Add Category</router-link>
                            <router-link :to="{ name: 'category'}" class="collapse-item">All Category</router-link>
                        </div>
                        </div>
                    </li>

            <!-- product side nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseBootstrap3"
                aria-expanded="true" aria-controls="collapseBootstrap3">
                <i class="fas fa-shopping-bag"></i>
                <span>Products</span>
                </a>
                <div id="collapseBootstrap3" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Products</h6>
                    
                    <router-link :to="{ name: 'store-product'}" class="collapse-item">Add Product</router-link>
                    <router-link :to="{ name: 'product'}" class="collapse-item">All Product</router-link>
                </div>
                </div>
            </li>

            <!-- Expense side nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseBootstrap4"
                aria-expanded="true" aria-controls="collapseBootstrap4">
                <i class="fas fa-money-check-alt"></i>
                <span>Expense</span>
                </a>
                <div id="collapseBootstrap4" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Expenses</h6>
                    
                    <router-link :to="{ name: 'store-expense'}" class="collapse-item">Add Expenses</router-link>
                    <router-link :to="{ name: 'expense'}" class="collapse-item">All Expenses</router-link>
                </div>
                </div>
            </li>

             <!-- Customer side nav -->
             <li class="nav-item">
                <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseBootstrap44"
                aria-expanded="true" aria-controls="collapseBootstrap44">
                <i class="fas fa-users"></i>
                <span>Customer</span>
                </a>
                <div id="collapseBootstrap44" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    
                    <router-link :to="{ name: 'store-customer'}" class="collapse-item">Add Customer</router-link>
                    <router-link :to="{ name: 'customer'}" class="collapse-item">All Customer</router-link>
                </div>
                </div>
            </li>

            <!-- Expense side nav -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseBootstrap5"
                aria-expanded="true" aria-controls="collapseBootstrap5">
                <i class="fas fa-money-bill-alt"></i>
                <span>Salary</span>
                </a>
                <div id="collapseBootstrap5" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Salary</h6>
                    
                    <router-link :to="{ name: 'given-salary'}" class="collapse-item">Pay Salary</router-link>
                    <router-link :to="{ name: 'salary'}" class="collapse-item">All Salary</router-link>
                </div>
                </div>
            </li>
            

            <li class="nav-item">
                <router-link :to="{ name: 'stock'}" class="nav-link">
                    <i class="fab fa-fw fa-wpforms"></i>
                    <span>Stock</span>
                </router-link>
            </li>
        

            <!-- Orders -->
            <li class="nav-item">
                    <a class="nav-link collapsed" href="javascript:void(0)" data-toggle="collapse" data-target="#collapseTable1" aria-expanded="true"
                    aria-controls="collapseTable1">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Orders</span>
                    </a>
                    <div id="collapseTable1" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                      
                        <router-link :to="{ name: 'order'}" class="collapse-item">Today Order</router-link>
                        <router-link :to="{ name: 'searchorder'}" class="collapse-item">Search</router-link>
                    </div>
                    </div>
            </li>

            </ul>
            <!-- Sidebar -->
        </nav>

        <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <!-- TopBar -->
                    <nav id="topbar" v-show="$route.path === '/' || $route.path === '/register' || $route.path === '/reset' || $route.path === '/forget' ? false : true" style="display:none;" class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
                        <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                        <ul class="navbar-nav ml-auto">
                    
                            <div class="topbar-divider d-none d-sm-block"></div>
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <router-link :to="{ name: 'logout'}"><img class="img-profile rounded-circle" src="{{ asset(env('APP_URL').'/backend/img/boy.png') }}" title="Logout" style="max-width: 60px">
                                    <span class="ml-2 d-none d-lg-inline text-white small">Logout </span></router-link>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- Topbar -->

                    <!-- Container Fluid-->
                    <div class="container-fluid" id="container-wrapper">
                        <router-view></router-view>
                    </div>
                    <!---Container Fluid-->
                </div>

                    <!-- Footer -->
                    <!-- <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - developed by
                                <b><a href="https://www.devphilip.com/" target="_blank">Dev Philip</a></b>
                                </span>
                            </div>
                        </div>
                    </footer> -->
                    <!-- Footer -->
        
      

        </div>
    </div>
</div>
  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script>
      let token = localStorage.getItem('token');
      if(token){
        $("#sidebar").css("display","")
        $("#topbar").css("display","")
      }
  </script>
  <script src="{{ asset(env('APP_URL').'/js/app.js') }}"></script>
  <script src="{{ asset(env('APP_URL').'/backend/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset(env('APP_URL').'/backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset(env('APP_URL').'/backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <script src="{{ asset(env('APP_URL').'/backend/js/ruang-admin.min.js') }}"></script>
  <script src="{{ asset(env('APP_URL').'/backend/vendor/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset(env('APP_URL').'/backend/js/demo/chart-area-demo.js') }}"></script>  
</body>

</html>