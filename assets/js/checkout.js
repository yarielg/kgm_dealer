(function(window, $) {
    "use strict";

    function CheckoutHandler(){
        var self = this;
        window.step = 1;
        self.init();
    }

    CheckoutHandler.prototype = {
        init: function () {
            var self = this;

            self.default();
            self.displaySteps();
            self.changeDirection();
            self.populateBillingInfo();
        },
        displaySteps(){
            $('.step').attr("style", "display: none !important");
            $('.step-' + window.step).attr("style", "display: block !important");
            var $billing = $('.billing-4-checkout');
            var $shipping = $('.shipping-4-checkout');
            var checkout_step = $('.billing-4-checkout').data('hide');

            if(window.step === 4){
                $('.step-4').attr("style", "display: inline !important");
                $('#payment').css("top", "-150px");
            }

            //Hiding/showing billing and shipping
            //Show only on step 1

            $shipping.css('display','none');
            $billing.css('display','block');
            if(window.step == checkout_step ){
                $shipping.css('display','block');
                $billing.css('display','none');
                $('#place_an_order').css('display','inline');
            }else{
                $('#place_an_order').css('display','none');
            }

            var go_back_btn  = $('.go_back').filter('.footer');
            var continue_btn = $('.continue').filter('.footer');
            go_back_btn.css('display', 'none');
            continue_btn.css('display', 'none');
            switch (window.step) {
                case 1:
                    continue_btn.css('display', 'inline-block');
                    break
                case 2:
                    go_back_btn.css('display', 'inline-block');
                    break
                case 3:
                    continue_btn.css('display', 'inline-block');
                    go_back_btn.css('display', 'inline-block');
                    break
                case 4:
                    go_back_btn.css('display', 'inline-block');
                    break
            }

            //Scroll  to top
           // $(window).scrollTop(0);
           // window.scrollTo({ top: 0, behavior: 'smooth' });
            var $scrollTo = $('.progtrckr');
            var $container = $("html,body");
            $("html, body").animate({scrollTop: $scrollTo.offset().top - $container.offset().top - 50 }, "slow");

        },
        displayHeadings(){
            var $heading_step_checkout = $('#heading_step_checkout');
            var steps = $heading_step_checkout.data('steps');
            $heading_step_checkout.text('');
            switch (window.step) {
                case 1:
                    $heading_step_checkout.text('STEP 1: BILLING ADDRESS');
                    break
                case 2:
                    $heading_step_checkout.text( steps == 2 ? 'STEP 2: PAYMENT' : 'STEP 2: CHOOSE FFL');
                    break
                case 3:
                    $heading_step_checkout.text('STEP 3: NFA AGREEMENTS');
                    break
                case 4:
                    $heading_step_checkout.text('STEP 4: PAYMENT');
                    break
            }
        },
        checkErrorsShippingFields(){
            return $('#billing_first_name').val().length === 0 ||
                $('#billing_last_name').val().length === 0 ||
                // $('#select2-billing_country-container').val().length === 0 ||
                $('#billing_address_1').val().length === 0 ||
                $('#billing_city').val().length === 0 ||
                // $('#select2-billing_state-container').val().length === 0 ||
                $('#billing_postcode').val().length === 0 ||
                $('#billing_phone').val().length === 0 ||
                $('#billing_email').val().length === 0;

        },
        changeStep(direction){
            var self = this;
            // If all the mandatory Check are not checked, then wi cant go to the next step
            if(window.step === 3 && $('input.mandatory_check').not(':checked').length > 0 && direction === 1){
                alert('You must check all the fields');
                return;
            }

            if(window.step === 1 && self.checkErrorsShippingFields()){
                alert('You have some empty/wrong fields');
                return;
            }

            if(direction === -1 && window.step !==1){
                window.step--;
                $('button.go_back').css('display', 'inline-block');
            }
            if(direction === 1 && window.step !== 4){
                window.step++;
            }
        },
        changeDirection(){
            var self = this;
            $('body').on('click', '.btn-step, radio-dealer' ,function(e){

                if($(this).hasClass('radio-dealer')){
                    var dealer = $(this).data('dealer');
                    dealer = JSON.parse(window.atob(dealer));
                    $('#dealer_info_selected').empty();
                    $('#dealer_info_selected').append('<h4 class="billing_heading"><strong>SELECTED FFL</strong></h4>\n' +
                        '    <p><strong>'+dealer.name+'</strong></p>\n' +
                        '    <p><strong>'+dealer.address+'</strong></p>\n' +
                        '    <p><strong>'+ dealer.city + ', ' + dealer.state + ' ' + dealer.zip + '</strong></p>\n' +
                        '    <p><strong><a href="tel:'+dealer.phone+'">'+dealer.phone+'</a></strong></p>');

                    $('#dealer_ffl_id').val(dealer.id)
                }


                if($(this).hasClass('go_back')){
                    self.changeStep(-1)
                }else{
                    self.changeStep(1)

                }
                self.displaySteps();
                self.stepBarUpdate();
                self.displayHeadings();
                self.populateBillingInfo();
            })

        },
        stepBarUpdate(){
            var current = 1;
            var done_class = 'progtrckr-done';
            $('ol.progtrckr li').each(function(step){
                if(current < window.step){
                    $(this).addClass(done_class);
                }else{
                    $(this).removeClass(done_class);
                    $(this).css('text-decoration', 'none');
                }
                current++;
            });
        },
        populateBillingInfo(){
            $('.billing_info_fields').empty();
            $('.billing_info_fields').html('<h4>BILLING ADDRESS</h4>' +
                '<p>'+$('#billing_first_name').val()+' ' + $('#billing_last_name').val() +'</p>' +
                '<p>'+$('#billing_address_1').val()+'</p>' +
                '<p>'+$('#billing_city').val()+', ' + $('#billing_state').val() +' ' + $('#billing_postcode').val() + '</p>' +
                '<p>'+ $('#billing_phone').val() +'</p>'
            );
        },
        default(){
            $('#ship-to-different-address-checkbox').attr('checked',false);
            setTimeout(function(){
                $('#billing_city_field').addClass('form-row-first');
                $('#billing_city_field').removeClass('form-row-wide');

                $('#billing_state_field').addClass('form-row-last');
                $('#billing_state_field').removeClass('form-row-wide');

            },2000);

            $('#place_an_order').on('click',function(){
                $('#place_order').trigger('click');
                //$('#place_order').click();
                //$('#regForm').submit();
            });

            $('#ship-to-different-address-checkbox').click(function(){
                    if($(this).checked){
                        $('#billing_info_fields').css('display','none');
                    }else{
                        $('#billing_info_fields').css('display','inline');
                    }
            });



        }
    }

    $(document).ready(function() {
        window.Kgm = window.Kgm || {};
        window.Kgm.CheckoutHandler = new CheckoutHandler();
        $('.progtrckr').on('click','.progtrckr-done', function(){
            window.step = $(this).data('step');
            window.Kgm.CheckoutHandler.displaySteps();
            window.Kgm.CheckoutHandler.stepBarUpdate();
            window.Kgm.CheckoutHandler.displayHeadings();
        });

        $('#ship-to-different-address-checkbox').on('change', function(){
            if($(this).is(':checked')){
                $('#payment').css('top','0');
            }else{
                $('#payment').css('top','-150px');
            }
        });
    });
})(window, window.jQuery);
