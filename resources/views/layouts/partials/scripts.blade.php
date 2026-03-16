 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
      <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


      <script>

         jQuery(function($) {



         var mobileItems = jQuery( '.nav-mobile .main-menu' );

         mobileItems.find( 'li.menu-item-has-children' ).append( '<i class="mobile-arrows fa fa-chevron-down"></i>' );

         jQuery(".nav-mobile .main-menu li.menu-item-has-children i.mobile-arrows").click(function() {

             if( jQuery( this ).hasClass( "fa-chevron-down" ) )

                 jQuery( this ).removeClass( "fa-chevron-down" ).addClass( "fa-chevron-up" );

             else

                 jQuery( this ).removeClass( "fa-chevron-up" ).addClass( "fa-chevron-down" );



             jQuery(this).parent().find('ul:first').slideToggle(300);

             jQuery(this).parent().find('> .mobile-arrows').toggleClass('is-open');

         });



         });



      </script>

      <script>

         $(document).ready(function () {

             $('.nav-toggle').click(function () {

                 var collapse_content_selector = $(this).attr('href');

                 var toggle_switch = $(this);

                 $(collapse_content_selector).toggle(function () {

                     if ($(this).css('display') == 'none') {

                         toggle_switch.html('Show');

                     } else {

                         toggle_switch.html('Hide');

                     }

                 });

             });



           $("#Closeexpand").click(function() {

                 $(".mobile-show").click();

             });





             });





         	$(".foot-brands-owl").owlCarousel({

             loop: true,

             margin: 10,

             mouseDrag: true,

             nav: true,

         	autoplay:false,

         	dots:false,

         	//autoplayTimeout:3000,

             navText: [

                 '<i class="fa fa-chevron-left">',

                 '<i class="fa fa-chevron-right">'

             ],

             items:4,

             responsive: {0: {items: 2},768: {items: 4},1000: {items: 4}}

         });









         	function showMore(){

             //removes the link

             document.getElementById('link').parentElement.removeChild('link');

             //shows the #more

             document.getElementById('more').style.display = "block";

         }







         $("#open_more").click(function () {

             $(".hotels a").toggleClass('text-left');

             $("#other_cities").toggleClass("active");

             $("#open_more").toggleClass("active");

             if ($("#open_more").html() == "-") {

                 $("#open_more").html("+");

             }

             else  {

                 $("#open_more").html("-");

             }

         });







         $("#open_moret").click(function () {

             $(".hotelst").toggleClass('text-left');

             $("#other_citiest").toggleClass("active");

             $("#open_moret").toggleClass("active");

             if ($("#open_moret").html() == "-") {

                 $("#open_moret").html("+");

             }

             else  {

                 $("#open_moret").html("-");

             }

         });

         $(".opp").click(function () {

                $("#LatestNews").hide();

         	if (screen.width <= 699) {



         	 $(".mobile-show").click();

             $("#slide-out").css("display", "none");

             $(".mobile-show").click(function() {

              $("#slide-out").css("display", "block");

             });

         	}

         });





         $(".mobile-show").click(function () {

         	   $("#slide-out").slideToggle();



         });

      </script>

      <script>

         function pprofiles(id, id2) {



             $(".profile").hide();

             var catches = $("#" + id).text();

             var titles = $("#" + id2).text();

             // alert(titles);



             $(".modal-title").text(titles);

             $("#modalbody").text(catches);

             $('#myModal').modal('show');





         }

      </script>
