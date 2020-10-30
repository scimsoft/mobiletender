/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });



window.addProduct=function(productID){
    jQuery.ajax({
        url: '/order/addproduct/' + productID,
        type: "GET",
        dataType: "json",
        success: function (data) {

            orderTotalBasket= (data * 1.1).toFixed(2) + "€";
            $('#ordertotal').html('<span class="btn-label"><i class="fa fa-shopping-cart"></i></span>&nbsp;'+ orderTotalBasket);
        }
    });
}


window.cancelProduct=function(productID){
    jQuery.ajax({
        url: '/order/cancelproduct/' + productID,
        type: "GET",
        dataType: "json",
        success: function (data) {

            orderTotalBasket= (data * 1.1).toFixed(2) + "€";
            $('#ordertotal').html('<span class="btn-label"><i class="fa fa-shopping-cart"></i></span>&nbsp;'+ orderTotalBasket);

        }
    });
}

window.moveImage = function(imgtodrag,cart){

    var imgclone = imgtodrag.clone()
        .offset({
            top: imgtodrag.offset().top,
            left: imgtodrag.offset().left
        })
        .css({
            'opacity': '0.5',
            'position': 'absolute',
            'height': '150px',
            'width': '150px',
            'z-index': '100'
        })
        .appendTo($('body'))
        .animate({
            'top': cart.offset().top + 10,
            'left': cart.offset().left + 10,
            'width': 75,
            'height': 75
        }, 1000);


    imgclone.animate({
        'width': 0,
        'height': 0
    }, function () {
        $(this).detach()
    });
}


