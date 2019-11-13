(function($){
	$(function(){
		$(document).ready(function(){
		  $(".owl-carousel").owlCarousel({
		  	loop:true,
		    margin:10,
		    nav:false,
		    autoplay:true,
		    autoplayTimeout:2000,
		    autoplayHoverPause:true,
		    responsive:{
		        0:{
		            items:1
		        },
		        600:{
		            items:3
		        },
		        1000:{
		            items:5
		        }
		    }
		   });
		});

		$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
		});

		$('.add-to-cart').submit(function(e){
			e.preventDefault();

			$.ajax({
				type: 'post',
				url: '/cart/add-to-cart',
				data: $(this).serialize(),/*Метод .serialize() возвращает строку пригодную для передачи через URL строку. 
											Данные могут собираться с многих объектов jQuery, включая <input>, <textarea>, 
											и <select>: $( "input, textarea, select" ).serialize();
											С помощью метода .serialize() можно очень быстро и просто собрать данные с формы*/
				success: function(result){
					showCart(result);
				}
			}); 
		});

		function showCart(result) {
			$('#exampleModal .modal-body').html(result);
			$('#exampleModal').modal();

		}

		$('.clear-cart').click(function(e){
			e.preventDefault();

			$.ajax({
				type: 'post',
				url: '/cart/clear-cart',
				
				success: function(result){
					showCart(result);
				}
			}); 
		});

		$('body').on('click', '.remove-product', function(e){
			e.preventDefault();
			let elem = $(this);

			$.ajax({
				type: 'post',
				url: '/cart/remove-product',
				data: {
					id: elem.closest('.product').data('id')
				},
				success: function(result){
					showCart(result);
				}
			}); 
		});


	});
})(jQuery);