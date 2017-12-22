$(document).ready(function () {
	$('#top-slide-2').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		itemWidth: 230,
		asNavFor: '#top-slides'
	});
	
	$('#top-slides').flexslider({
		animation: "slide",
		controlNav: false,
		animationLoop: false,
		sync: "#top-slide-2"
	});
	
	$("#top-slide").owlCarousel({
		items: 1,
		loop: true,
		autoplay: true,
		autoplaySpeed: 1500
	});

	$(".next").click(function () {
		$('#top-slide').trigger('next');
	});

	$(".prev").click(function () {
		$('#top-slide').trigger('prev');
	});

	$(".hot-videos-content-slide").owlCarousel({
		items: 1,
		loop: false,
		autoplay: true,
		autoplaySpeed: 1500
	});

	$(".hot-videos-control-left").click(function () {
		$('.hot-videos-content-slide').trigger('prev');
	});

	$(".hot-videos-control-right").click(function () {
		$('.hot-videos-content-slide').trigger('next');
	});

	//Slide tin tức trang chủ: tin khuyến mãi
	$("#news-slide-tkm").owlCarousel({
		loop: false,
		autoplay: true,
		autoplaySpeed: 1500,
		margin: 30,
		responsive: {
			0: {
				items: 1
			},
			480: {
				items: 2
			},
			992: {
				items: 4
			}
		}
	});

	//button next slide tin tức trang chủ
	$(".next1").click(function () {
		$('#news-slide-tmn, #news-slide-tvcn, #news-slide-tkm, #news-slide-hdkt').trigger('next');
	});

	//button previous slide tin tức trang chủ
	$(".prev1").click(function () {
		$('#news-slide-tmn, #news-slide-tvcn, #news-slide-tkm, #news-slide-hdkt').trigger('prev');
	});

	//slide sản phẩm hot trang chủ
	$(".hot-products-slide").owlCarousel({
		loop: false,
		autoplay: false,
		autoplaySpeed: 1500,
		responsive: {
			0: {
				items: 2
			},
			480: {
				items: 2
			},
			769: {
				items: 3
			},
			992: {
				items: 3
			}
		}
	});

	//button next slide sản phẩm hot trang chủ
	$(".next2").click(function () {
		$('.hot-products-slide').trigger('next');
	});

	//button previous slide sản phẩm hot trang chủ
	$(".prev2").click(function () {
		$('.hot-products-slide').trigger('prev');
	});

	$(".product-img-slide").owlCarousel({
		items: 1,
		loop: false,
		autoplay: false,
		autoplaySpeed: 1500,
		dotsContainer: $('.product-img-slide-dot .dot-custom')
	});

	$(".rating-bt-right-slide").owlCarousel({
		items: 1,
		loop: false,
		autoplay: true,
		autoplaySpeed: 1500
	});

	//CUSTOM SINGLE.PHP

	$(".read-more").click(function () {
		$(".see-content").hide();
		$(".col-content-1").removeClass("col-content");
	});
	
	$('.opencmt').click(function () {
		$('#fb-cmt, #wp-cmt').hide();
		$($(this).attr('href')).slideToggle();
		return false;
	});
	$('.wpcf7-text, .wpcf7-textarea').hover(function () {
		$(this).removeClass('wpcf7-not-valid');
	}, function () {
		/* Stuff to do when the mouse leaves the element */
	});
	$('.wpcf7-textarea').attr('rows', 3);


	var title = $('.product__detail__heading').html();
	var price = $('.product__detail__top__content__right__price span.price').html();
	var color = $('.product__detail__top__content__right__color__item.active').attr('data-name-color');
	if($('.icare-option')[0]) {
        var goibh = 'iCare';
	} else {
		var goibh = 'Bảo hành công ty';
	}
	var productname = title + ' - Màu: ' + color + ' - Giá: ' + price + ' - Gói bảo hành: ' + goibh;
	$('.price_contact_form').html(price);
	$('#product, #product2').val(productname);
	$('#price_tragop').val(price);
	$('#color_tragop').val(color);
	$('.title-tab li a').click(function () {
		$('.tab_content').hide();
		$($(this).attr('href')).fadeIn();
		$('.title-tab li a').removeClass('active');
		$(this).addClass('active');
		return false;
	});
	$('.ms').html('Màu: '+color);
	$('.gbh').html('Gói bảo hành: '+goibh);

	$('.product__detail__top__content__right__color__item').click(function() {
		$('.product__detail__top__content__right__color__item').removeClass('active');
		var color_id = $(this).attr('data-color-id');
		$('[data-color-id='+color_id+']').addClass('active');
		var data_price_color = $(this).attr('data-price-color');
		data_price_color = data_price_color.replace(/[.]/g, '');
        data_price_color = parseInt(data_price_color);

		if($('.icare-option')[0]) {
			var data_price_baohanh = $('.product__detail__top__content__right__icare__select').val();
        	data_price_baohanh = parseInt(data_price_baohanh);
		} else {
			var data_price_baohanh = 0;
		}

		if($('.product__detail__top__content__right__formality')[0]) {
			var data_price_hinhthuc = $('.product__detail__top__content__right__formality__select').val();
        	data_price_hinhthuc = data_price_hinhthuc.replace(/[.]/g, '');
        	data_price_hinhthuc = parseInt(data_price_hinhthuc);
		} else {
			var data_price_hinhthuc = 0;
		}
        
        if($('.product__detail__top__content__right__capacity')[0]) {
        	var data_price_dungluong = $('.product__detail__top__content__right__capacity__select').val();
        	data_price_dungluong = data_price_dungluong.replace(/[.]/g, '');
        	data_price_dungluong = parseInt(data_price_dungluong);
        } else {
        	var data_price_dungluong = 0;
        }

        var data_price = data_price_color + data_price_baohanh + data_price_dungluong + data_price_hinhthuc;
        $('.product__detail__top__content__right__price span.price').html(data_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
        var color = $('.product__detail__top__content__right__color__item.active').attr('data-name-color');
        $('.ms').html('Màu: '+color);
        if($('.icare-option')[0]) {
	        var goibh = $('.product__detail__top__content__right__icare__select').val().split('-');
	        goibh = goibh[1];
		} else {
			var goibh = 'Bảo hành công ty';
		}
		var soluong = $('.product__detail__top__content__right__color__item.active').attr('data-sl-color');
		$('span.sl').html('('+soluong+')');
        $('.gbh').html('Gói bảo hành: '+goibh);
        var price = $('.product__detail__top__content__right__price span.price').html();
        var productname = title + ' - Màu: ' + color + ' - Giá: ' + price + ' - Gói bảo hành: ' + goibh;
        $('.price_contact_form').html(price);
        $('#product, #product2').val(productname);
		$('#price_tragop').val(price);
		$('#color_tragop').val(color);
	});

	$('.product__detail__top__content__right__icare__select').change(function() {
        var data_price_baohanh = $(this).val().split('-');
        $(".product__detail__top__content__right__icare__select").val($(this).find("option:selected").val());
        data_price_baohanh = data_price_baohanh[0];
        data_price_baohanh = parseInt(data_price_baohanh);
        
        if($('.product__detail__top__content__right__color__item.active')[0]) {
        	var data_price_color = $('.product__detail__top__content__right__color__item.active').attr('data-price-color');
			data_price_color = data_price_color.replace(/[.]/g, '');
	        data_price_color = parseInt(data_price_color);
		} else {
			var data_price_color = 0;
		}
        
        if($('.product__detail__top__content__right__formality')[0]) {
			var data_price_hinhthuc = $('.product__detail__top__content__right__formality__select').val();
        	data_price_hinhthuc = data_price_hinhthuc.replace(/[.]/g, '');
        	data_price_hinhthuc = parseInt(data_price_hinhthuc);
		} else {
			var data_price_hinhthuc = 0;
		}
        
        if($('.product__detail__top__content__right__capacity')[0]) {
        	var data_price_dungluong = $('.product__detail__top__content__right__capacity__select').val();
        	data_price_dungluong = data_price_dungluong.replace(/[.]/g, '');
        	data_price_dungluong = parseInt(data_price_dungluong);
        } else {
        	var data_price_dungluong = 0;
        }

        var data_price = data_price_color + data_price_baohanh + data_price_dungluong + data_price_hinhthuc;
        
        $('.product__detail__top__content__right__price span.price').html(data_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
        var color = $('.product__detail__top__content__right__color__item.active').attr('data-name-color');
        $('.ms').html('Màu: '+color);
        if($('.icare-option')[0]) {
	        var goibh = $('.product__detail__top__content__right__icare__select').val().split('-');
	        goibh = goibh[1];
		} else {
			var goibh = 'Bảo hành công ty';
		}
        $('.gbh').html('Gói bảo hành: '+goibh);
        var price = $('.product__detail__top__content__right__price span.price').html();
        var productname = title + ' - Màu: ' + color + ' - Giá: ' + price + ' - Gói bảo hành: ' + goibh;
        $('.price_contact_form').html(price);
        $('#product, #product2').val(productname);
		$('#price_tragop').val(price);
		$('#color_tragop').val(color);
    });

    $('.product__detail__top__content__right__capacity__select').change(function() {
        var data_price_dungluong = $(this).val();
        $(".product__detail__top__content__right__capacity__select").val($(this).find("option:selected").val());
        data_price_dungluong = data_price_dungluong.replace(/[.]/g, '');
        data_price_dungluong = parseInt(data_price_dungluong);
        
        if($('.product__detail__top__content__right__color__item.active')[0]) {
        	var data_price_color = $('.product__detail__top__content__right__color__item.active').attr('data-price-color');
			data_price_color = data_price_color.replace(/[.]/g, '');
	        data_price_color = parseInt(data_price_color);
		} else {
			var data_price_color = 0;
		}

		if($('.icare-option')[0]) {
			var data_price_baohanh = $('.product__detail__top__content__right__icare__select').val();
        	data_price_baohanh = parseInt(data_price_baohanh);
		} else {
			var data_price_baohanh = 0;
		}
        
        if($('.product__detail__top__content__right__formality')[0]) {
			var data_price_hinhthuc = $('.product__detail__top__content__right__formality__select').val();
        	data_price_hinhthuc = data_price_hinhthuc.replace(/[.]/g, '');
        	data_price_hinhthuc = parseInt(data_price_hinhthuc);
		} else {
			var data_price_hinhthuc = 0;
		}

        var data_price = data_price_color + data_price_baohanh + data_price_dungluong + data_price_hinhthuc;
        
        $('.product__detail__top__content__right__price span.price').html(data_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
        var color = $('.product__detail__top__content__right__color__item.active').attr('data-name-color');
        $('.ms').html('Màu: '+color);
        if($('.icare-option')[0]) {
	        var goibh = $('.product__detail__top__content__right__icare__select').val().split('-');
	        goibh = goibh[1];
		} else {
			var goibh = 'Bảo hành công ty';
		}
        $('.gbh').html('Gói bảo hành: '+goibh);
        var price = $('.product__detail__top__content__right__price span.price').html();
        var productname = title + ' - Màu: ' + color + ' - Giá: ' + price + ' - Gói bảo hành: ' + goibh;
        $('.price_contact_form').html(price);
        $('#product, #product2').val(productname);
		$('#price_tragop').val(price);
		$('#color_tragop').val(color);
    });
    
    $('.product__detail__top__content__right__formality__select').change(function() {
        var data_price_hinhthuc = $(this).val();
        $(".product__detail__top__content__right__formality__select").val($(this).find("option:selected").val());
        data_price_hinhthuc = data_price_hinhthuc.replace(/[.]/g, '');
        data_price_hinhthuc = parseInt(data_price_hinhthuc);
        
        if($('.product__detail__top__content__right__color__item.active')[0]) {
        	var data_price_color = $('.product__detail__top__content__right__color__item.active').attr('data-price-color');
			data_price_color = data_price_color.replace(/[.]/g, '');
	        data_price_color = parseInt(data_price_color);
		} else {
			var data_price_color = 0;
		}

		if($('.icare-option')[0]) {
			var data_price_baohanh = $('.product__detail__top__content__right__icare__select').val();
        	data_price_baohanh = parseInt(data_price_baohanh);
		} else {
			var data_price_baohanh = 0;
		}
        
        if($('.product__detail__top__content__right__capacity')[0]) {
        	var data_price_dungluong = $('.product__detail__top__content__right__capacity__select').val();
        	data_price_dungluong = data_price_dungluong.replace(/[.]/g, '');
        	data_price_dungluong = parseInt(data_price_dungluong);
        } else {
        	var data_price_dungluong = 0;
        }
        
        var data_price = data_price_color + data_price_baohanh + data_price_dungluong + data_price_hinhthuc;
        $('.product__detail__top__content__right__price span.price').html(data_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
        var color = $('.product__detail__top__content__right__color__item.active').attr('data-name-color');
        $('.ms').html('Màu: '+color);
        if($('.icare-option')[0]) {
	        var goibh = $('.product__detail__top__content__right__icare__select').val().split('-');
	        goibh = goibh[1];
		} else {
			var goibh = 'Bảo hành công ty';
		}
        $('.gbh').html('Gói bảo hành: '+goibh);
        var price = $('.product__detail__top__content__right__price span.price').html();
        var productname = title + ' - Màu: ' + color + ' - Giá: ' + price + ' - Gói bảo hành: ' + goibh;
        $('.price_contact_form').html(price);
        $('#product, #product2').val(productname);
		$('#price_tragop').val(price);
		$('#color_tragop').val(color);
    });

	$('.product__gallery__slide__bottom').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 130,
        itemMargin: 5,
        asNavFor: '.product__gallery__slide__top'
    });

    $('.product__gallery__slide__top').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: ".product__gallery__slide__bottom",
        start: function(slider){
            $('body').removeClass('loading');
        },
    });

	$('.cancel, .ovf').click(function () {
		$('.contact-form, .ovf').fadeOut();
		return false;
	});
	
	$('#dathangtuxa').click(function () {
		$('#form2').hide();
		$('#form1').show();
	});
	$('#option2, #option3').hide();
	$('.option1').click(function() {
		$('#option1').show();
		$('#option2, #option3').hide();
	});
	$('.option2').click(function() {
		$('#option2').show();
		$('#option1, #option3').hide();
	});
	$('.option3').click(function() {
		$('#option3').show();
		$('#option2, #option1').hide();
	});
	$('#tragop_submit').click(function () {
		$('#form1').hide();
		$('#form2').show();
	});
	$('.nxsp').click(function () {
		$('.title-tab li a').removeClass('active');
		$('.title-tab li:first-child a').addClass('active');
		$('.tab_content').hide();
		$('#tab1').fadeIn();
	});
	$(window).load(function () {
		$('.caption_ddnb').each(function () {
			var h = ($(this).prev('img').height() - $(this).height()) / 2;
			$(this).css('margin-top', h + 'px');
		});
	});

	//CUSTOM TAXONOMY-NEW_CATEGORY.PHP
	$("#news-slide").owlCarousel({
		items: 1,
		loop: false,
		autoplay: true,
		autoplaySpeed: 1500,
	});
	$(".news-slide-prev").click(function () {
		$('#news-slide').trigger('prev');
	});

	$(".news-slide-next").click(function () {
		$('#news-slide').trigger('next');
	});

	$('.news-cat li a').mouseover(function (e) {
		e.preventDefault()
		$(this).tab('show')
	});

	//	CUSTOM TAXONAMY-VIDEO_CATEGORY.PHP
	$("#video-slide").owlCarousel({
		items: 4,
		loop: false,
		autoplay: true,
		autoplaySpeed: 1500,
		margin: 15,
	});
	$(".next5").click(function () {
		$('#video-slide').trigger('next');
	});

	$(".prev5").click(function () {
		$('#video-slide').trigger('prev');
	});

	$("#video-slide-2").owlCarousel({
		items: 4,
		loop: false,
		autoplay: true,
		autoplaySpeed: 1500,
		margin: 15,
	});
	$(".next6").click(function () {
		$('#video-slide-2').trigger('next');
	});

	$(".prev6").click(function () {
		$('#video-slide-2').trigger('prev');
	});

	$("#video-slide-3").owlCarousel({
		items: 4,
		loop: false,
		autoplay: true,
		autoplaySpeed: 1500,
		margin: 15,
	});
	$(".next7").click(function () {
		$('#video-slide-3').trigger('next');
	});

	$(".prev7").click(function () {
		$('#video-slide-3').trigger('prev');
	});

	$("#video-slide-4").owlCarousel({
		items: 4,
		loop: false,
		autoplay: true,
		autoplaySpeed: 1500,
		margin: 15,
	});
	$(".next8").click(function () {
		$('#video-slide-4').trigger('next');
	});

	$(".prev8").click(function () {
		$('#video-slide-4').trigger('prev');
	});
	
	$("#single-next").click(function () {
		$('.rating-bt-right-slide').trigger('next');
	});

	$("#single-prev").click(function () {
		$('.rating-bt-right-slide').trigger('prev');
	});

});

$(document).ready(function(){
     $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('#back-to-top').fadeIn();
            } else {
                $('#back-to-top').fadeOut();
            }
        });
        // scroll body to 0px on click
        $('#back-to-top').click(function () {
            $('#back-to-top').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 800);
            return false;
        });
        
        $('#back-to-top').tooltip('show');

});

$(document).ready(function(){
	var w = $('.container').width();
	if(w < 768) {
		$('.navbar-brand').html('Danh mục sản phẩm');
	}
	if (w > 768) {
		$('.menu-item-24769 > a').click(function () {
			window.location="http://clickbuy.com.vn/danh-muc/iphone";
		});
	}
	if(w < 481) {
		$('#top-slides').hide();
		$('#top-slide-2').hide();
		$('#top-slide').show();
		$('.bt-news').show();
	} else {
		$('#top-slides').show();
		$('#top-slide-2').show();
		$('#top-slide').hide();
		$('.bt-news').hide();
	}
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			var w = $('.container-fluid').width();
			if(w > 768 ) {
				$('#nav-custom-fix').addClass('navbar-fixed-top');
			}
			w = w - 1110;
			w = w / 2;
			
			$('.navbar-fixed-top').css('padding-left', w +'px');
		} else {
			$('.navbar-default').removeClass('navbar-fixed-top');
			$('.navbar-default').css('padding-left', '0px');
		}
	});
        
});

$(document).ready(function () {
	$('#sel1').change(function () {
		if($(this).val() == 'option-hn') {
			window.location="http://clickbuy.com.vn";
		}
		if($(this).val() == 'option-hcm') {
			window.location="http://hcm.clickbuy.com.vn";
		}
	});
	
	$('.bypostauthor .comment-wrap .comment-author .qtv').show();
});