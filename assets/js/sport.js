//add bootstrap
//  require('bootstrap');
// require('justifiedGallery/dist/css/justifiedGallery.css');
require('jquery/src/jquery');
// require('justifiedGallery/dist/js/jquery.justifiedGallery');
// require('ckeditor/ckeditor');
// require('justifiedGallery/dist/js/jquery.justifiedGallery.min');
//  require('justified-allery/lib/dist/js/jquery.justifiedGallery');
// require('jquery-colorbox/jquery.colorbox-min');
//
// workaround for (possible) webpack bug to prevent error from UglifyJs 'Unexpected token: name (self) [js/app.2b7036a4c723ac53590a.js:12552,12]'
// require('amazon-autocomplete/src/amazon-autocomplete');
// require('amazon-autocomplete/dist/amazon-autocomplete.min');
//enable Jquery
const $ = require('jquery');
global.$ = global.jQuery = $;

// $('#sortScore').on('click', function (e) {
//     // alert('h');
//     // e.preventDefault();
//     // setupCustomer($(this).data('customer'));
//     // $(this).removeClass('setup-customer').addClass('change-customer').html('<i class="icon-refresh"></i>&nbsp;{l s="Change" js=1}').blur();
//     //                                                                                                     $(this).closest('.customerCard').addClass('selected-customer');
//     //                                                                                                     $('.selected-customer .panel-heading').prepend('<i class="icon-ok text-success"></i>');
//     // $('.customerCard').not('.selected-customer').remove();
//     // $('#search-customer-form-group').hide();
//     // var query = 'ajax=1&token='+token+'&action=changePaymentMethod&id_customer='+$(this).data('customer');
//     $.ajax({
//         type: 'POST',
//         url: '{{ path(sort) }}',
//         // headers: {"cache-control": "no-cache"},
//         // cache: false,
//         dataType: 'json',
//         data: query,
//         success: function (data) {
//             alert(data);
//         }
//             // if (data.result)
//             //     $('#payment_module_name').replaceWith(data.view)
//         // }
//     });
// });
