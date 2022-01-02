let login = require('./components/auth/Login.vue').default; //route path
let register = require('./components/auth/Register.vue').default; //route path
let forget = require('./components/auth/Forget.vue').default; //route path
let reset = require('./components/auth/Reset.vue').default; //route path
let home = require('./components/Home.vue').default; //route path 

let logout = require('./components/auth/Logout.vue').default; //route path 

//Employee Components
let storeemployee = require('./components/employee/Create.vue').default; //route path
let employee = require('./components/employee/Index.vue').default; //route path
let editemployee = require('./components/employee/Edit.vue').default; //route path

//Supplier Components
let storesupplier = require('./components/supplier/Create.vue').default; //route path
let supplier = require('./components/supplier/Index.vue').default; //route path
let editsupplier = require('./components/supplier/Edit.vue').default; //route path

//Category Components
let storecategory = require('./components/category/Create.vue').default; //route path
let category = require('./components/category/Index.vue').default; //route path
let editcategory = require('./components/category/Edit.vue').default; //route path

//Product Components
let storeproduct = require('./components/product/Create.vue').default; //route path
let product = require('./components/product/Index.vue').default; //route path
let editproduct = require('./components/product/Edit.vue').default; //route path

//Expense Components
let storeexpense = require('./components/expense/Create.vue').default; //route path
let expense = require('./components/expense/Expense.vue').default; //route path
let editexpense = require('./components/expense/Edit.vue').default; //route path

//Salary Components
let salary = require('./components/salary/All_employee.vue').default; //route path
let paysalary = require('./components/salary/Create.vue').default; //route path

let allsalary = require('./components/salary/Index.vue').default; //route path
let viewsalary = require('./components/salary/View.vue').default; //route path
let editsalary = require('./components/salary/Edit.vue').default; //route path

//Stock Components
let stock = require('./components/product/Stock.vue').default; //route path
let editstock = require('./components/product/Edit-stock.vue').default; //route path


//Customer Components
let storecustomer = require('./components/customer/Create.vue').default; //route path
let customer = require('./components/customer/Index.vue').default; //route path
let editcustomer = require('./components/customer/Edit.vue').default; //route path

//POS Component
let pos = require('./components/pos/pointofsale.vue').default; //route path

//Order Component
let order = require('./components/order/order.vue').default; //route path
let vieworder = require('./components/order/vieworder.vue').default; //route path

let searchorder = require('./components/order/search.vue').default; //route path


// let globalURL = '';
// let base  = '';

let globalURL = 'https://www.devphilip.com/projects/inventory/public';
let base = 'projects/inventory';

window.globalURL = globalURL;
window.base = base;

export const routes = [
    //auth route
    { path:  '/', component: login, name: '/' },
    { path:  '/register', component: register, name: 'register' },
    { path:  '/forget', component: forget, name: 'forget' },
    { path:  '/home', component: home, name: 'home' },
    { path:  '/reset', component: reset, name: 'reset' },

    //logout
    { path:  '/logout', component: logout, name: 'logout' },


    { path:  '/store-employee', component: storeemployee, name: 'store-employee' },
    { path:  '/employee', component: employee, name: 'employee' },
    { path:  '/edit-employee/:id', component: editemployee, name: 'edit-employee' },

    { path:  '/store-supplier', component: storesupplier, name: 'store-supplier' },
    { path:  '/supplier', component: supplier, name: 'supplier' },
    { path:  '/edit-supplier/:id', component: editsupplier, name: 'edit-supplier' },

    //Category
    { path:  '/store-category', component: storecategory, name: 'store-category' },
    { path:  '/category', component: category, name: 'category' },
    { path:  '/edit-category/:id', component: editcategory, name: 'edit-category' },

    //Product
    { path:  '/store-product', component: storeproduct, name: 'store-product' },
    { path:  '/product', component: product, name: 'product' },
    { path:  '/edit-product/:id', component: editproduct, name: 'edit-product' },

    //Expenses
    { path:  '/store-expense', component: storeexpense, name: 'store-expense' },
    { path:  '/expense', component: expense, name: 'expense' },
    { path:  '/edit-expense/:id', component: editexpense, name: 'edit-expense' },

    //Salary Routes
    { path:  '/given-salary', component: salary, name: 'given-salary' },
    { path:  '/pay-salary/:id', component: paysalary, name: 'pay-salary' },
    { path:  '/salary', component: allsalary, name: 'salary' },
    { path:  '/view-salary/:id', component: viewsalary, name: 'view-salary' },
    { path:  '/edit-salary/:id', component: editsalary, name: 'edit-salary' },

    //Stock Routes
    { path:  '/stock', component: stock, name: 'stock' },
    { path:  '/edit-stock/:id', component: editstock, name: 'edit-stock' },

    //Customer
    { path:  '/store-customer', component: storecustomer, name: 'store-customer' },
    { path:  '/customer', component: customer, name: 'customer' },
    { path:  '/edit-customer/:id', component: editcustomer, name: 'edit-customer' },

    //POS Routes
    { path:  '/pos', component: pos, name: 'pos' },

    //Orders Routes
    { path:  '/order', component: order, name: 'order' },

    //Orders Routes
    { path:  '/view-order/:id', component: vieworder, name: 'view-order' },
    { path:  '/searchorder', component: searchorder, name: 'searchorder' },
]