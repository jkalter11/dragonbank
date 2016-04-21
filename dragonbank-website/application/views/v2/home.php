    <!-- <div class="row">
	<div class="col-content">
		<div class="col-sm-12" id="home-content">	
			<h1 style="margin: 20px 0 0 20px">Helping parents</h1>
			<h1 style="margin: 5px 0 0 100px; font-weight: 900;">TEACH MONEY SKILLS</h1>
			<h1 style="margin: 5px 0 40px 70px">to their kids.</h1>

			<ul class="ribbons">
				<li><div>Always <strong>know how much money</strong> your child HAS saved</div></li>
				<li><div><strong>Track and record</strong> every deposit accurately ONLINE!</div></li>
				<li><div><strong>Weekly email saving tips</strong></div></li>
				<li><div><strong>Set the foundation</strong> for your child's <strong>financial future</strong></div></li>
				<li><div><strong>Activities and Challenges</strong> teaching kids money lessons</div></li>
			</ul>
		</div>
	</div>
</div> -->



							<section id="main-slider28" class="main-slider carousel slide fade-effect">
							   <!-- Loading Spinner -->
							   <div id="spinner28" class="spinner">
							      <div class="wBall" id="wBall_1">
							         <div class="wInnerBall"></div>
							      </div>
							      <div class="wBall" id="wBall_2">
							         <div class="wInnerBall"></div>
							      </div>
							      <div class="wBall" id="wBall_3">
							         <div class="wInnerBall"></div>
							      </div>
							      <div class="wBall" id="wBall_4">
							         <div class="wInnerBall"></div>
							      </div>
							      <div class="wBall" id="wBall_5">
							         <div class="wInnerBall"></div>
							      </div>
							   </div>
							   <!--/ Loading Spinner -->
								<div class="main-slider-frame"></div>
								<!-- Slider Items -->
    							<div class="carousel-inner invisible">
                    			<section class="item active " style="background-image: url(<?php echo base_url();?>assets/img/simg01.jpg);">
			                		<div class="carousel-content">
			                      <!--  	<div class="title-before" data-animate-in="fadeInDown" data-animate-out="fadeOutUp">Pet Care</div> -->
			                        <h1 class="title" data-animate-in="fadeInRight" data-animate-out="fadeOutRight">Helping Teach Kids to Spend Wisely</h1>
			                    		<!-- <a href="#" class="btn btn-arrow" data-animate-in="fadeInUp" data-animate-out="fadeOutDown"><span>Read More</span></a> -->
			                		</div>
			            		</section>
			                  <section class="item  " style="background-image: url(<?php echo base_url();?>assets/img/simg02.jpg);">
			                		<div class="carousel-content">
			                     <!--    <div class="title-before" data-animate-in="fadeInDown" data-animate-out="fadeOutUp">Did you know?</div> -->
			                        <h1 class="title" data-animate-in="fadeInRight" data-animate-out="fadeOutRight">Helping Kids to Save Effectively</h1>
			                    	<!-- 	<a href="#2" class="btn btn-arrow" data-animate-in="fadeInUp" data-animate-out="fadeOutDown"><span>Read More</span></a> -->
			                		</div>
			            		</section>
			                  <section class="item " style="background-image: url(<?php echo base_url();?>assets/img/simg03.jpg);">
			                		<div class="carousel-content">
                                	<!-- <div class="title-before" data-animate-in="fadeInDown" data-animate-out="fadeOutUp">Pet Adoption</div> -->
                                 <h1 class="title" data-animate-in="fadeInRight" data-animate-out="fadeOutRight">Helping Kids Learn to Give Generously</h1>
                    					<!-- <a href="#3" class="btn btn-arrow" data-animate-in="fadeInUp" data-animate-out="fadeOutDown"><span>Read More</span></a> -->
					               </div>
					            </section>
					            <section class="item  " style="background-image: url(<?php echo base_url();?>assets/img/simg04.jpg);">
					               <div class="carousel-content">
					                	<!-- <div class="title-before" data-animate-in="fadeInDown" data-animate-out="fadeOutUp">Pet Car</div> -->
					                  <h1 class="title" data-animate-in="fadeInRight" data-animate-out="fadeOutRight"> Set the foundation for your child's financial future</h1>
					                 <!--  <a href="#4" class="btn btn-arrow" data-animate-in="fadeInUp" data-animate-out="fadeOutDown"><span>Read More</span></a> -->
					               </div>
					            </section>
					            <section class="item  " style="background-image: url(<?php echo base_url();?>assets/img/img05.jpg);">
					               <div class="carousel-content">
					                	<!-- <div class="title-before" data-animate-in="fadeInDown" data-animate-out="fadeOutUp">Pet Car</div> -->
					                  <h1 class="title" data-animate-in="fadeInRight" data-animate-out="fadeOutRight">  Dragon Bank.....because everyone deserves financial awareness</h1>
					                 <!--  <a href="#4" class="btn btn-arrow" data-animate-in="fadeInUp" data-animate-out="fadeOutDown"><span>Read More</span></a> -->
					               </div>
					            </section>
				            </div>
				    			<!--/ Slider Items -->
								<!-- Slider Bullets -->
							   <div class="carousel-indicators-container">
							     	<div class="carousel-indicators-right">
						            <div class="carousel-indicators-left">
						               <ol class="carousel-indicators">
						               <li data-target="#main-slider28" data-slide-to="0" class="active"></li><li data-target="#main-slider28" data-slide-to="1" class=""></li><li data-target="#main-slider28" data-slide-to="2" class=""></li><li data-target="#main-slider28" data-slide-to="3" class=""></li>                </ol>
						            </div>
							      </div>
							   </div>
							   <!--/ Slider Bullets -->
								<!-- Slider Arrows -->
								<a class="carousel-control left" href="#main-slider28" data-slide="prev"></a>
								<a class="carousel-control right" href="#main-slider28" data-slide="next"></a>
								<!--/ Slider Arrows -->
							</section>
							<script>
							    var $ = jQuery;
							    $('#main-slider28').prepend('<img src="<?php echo base_url();?>assets/img/slide-1.jpg" alt="" id="testimage28" class="hidden">');

							    // Main Slider
							    $.fn.sliderApi = function() {
							        var slider = $(this),
							            animateClass;

							        slider.find('[data-animate-in]').addClass('animated');

							        // Animation when Slide Appear
							        function animateSlide() {
							            slider.find('.active [data-animate-in], .carousel-indicators, .carousel-control').each(function () {
							                var $this = $(this);
							                animateClass = $this.data('animate-in');
							                $this.addClass(animateClass);
							            });
							            slider.find('.active [data-animate-in], .carousel-indicators, .carousel-control').each(function () {
							                var $this = $(this);
							                animateClass = $this.data('animate-out');
							                $this.removeClass(animateClass);
							            });
							        }

							        // Animation when Slide Disappear
							        function animateSlideEnd() {
							            slider.find('.active [data-animate-in], .carousel-indicators, .carousel-control').each(function () {
							                var $this = $(this);
							                animateClass = $this.data('animate-in');
							                $this.removeClass(animateClass)
							            });
							            slider.find('.active [data-animate-in], .carousel-indicators, .carousel-control').each(function () {
							                var $this = $(this);
							                animateClass = $this.data('animate-out');
							                $this.addClass(animateClass);
							            });
							        }

							        animateSlide();

							        slider.on('slid.bs.carousel', function () {
							            animateSlide();
							        });
							        slider.on('slide.bs.carousel', function () {
							            animateSlideEnd();
							        });

							        if (Modernizr.touch) {
							            slider.find('.carousel-inner').swipe( {
							                swipeLeft: function() {
							                    $(this).parent().carousel('prev');
							                },
							                swipeRight: function() {
							                    $(this).parent().carousel('next');
							                },
							                threshold: 30
							            })
							        }
							    };

							    $('#testimage28').load(function() {
							        $("#spinner28, #testimage28").remove();
							        $("#main-slider28 .carousel-inner").removeClass('invisible').addClass('animated fadeIn');
							        $('#main-slider28').carousel({interval: 8000, pause: 'none'}).sliderApi();
							    });
							</script>
							<style>
							 .error{
							    color:red;
							  }
							</style>
							<script>
							function remove_validation_error(id){
							//alert(data);

							$("#error_"+id).html('');


							}
							</script>
							<div class="show_msg" style="font-size:22px; color:red;">
										
										<?php echo isset($mess) ? $mess : ''; ?>	
									</div>
							<div class="row clearfix ">
								
	
	
							   <div class="col-sm-6">
							   	<section class="box widget-post">
							   		<div class="box-header" style="background-color: #82953f"></div>
							         <div class="box-content">
							         
							           	<article class="post clearfix">
							           		<header class="entry-header">
								             	<div class="entry-meta">
								                 	
								             	</div>
								               <h3 class="entry-title" style="text-align:center !important">Returning User? <br/>Log-In to Dragon Bank!</h3>
							               </header>


							               <div class="entry-content">
								              	<form class="form-horizontal default-form" action="/new/login" method="post" role="form">
														<div class="form-group">
															<div class="col-sm-12">
															<input id="username" class="form-control" type="text" placeholder="Username or Email" name="user" id="username" onchange="remove_validation_error(this.id)">
															
															<div id="error_username">
															
															<?php echo form_error('username', '<div class="error">', '</div>'); ?>
															</div>
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-12">
																<input id="password" class="form-control" type="password" placeholder="Password" name="user_password" id="password" onchange="remove_validation_error(this.id)">
																 <div id="error_password">
																 <?php echo form_error('password', '<div class="error">', '</div>'); ?>
																	</div>
															</div>
														</div>
														<div class="form-group">
															<div class="col-sm-8 col-sm-offset-2">
																<input class="btn btn-primary" type="submit" value="Access My Dragon Bank Account">
															</div>
														</div>
													</form>
							               </div>
							               
							               <!-- <footer class="entry-meta">
							                  <a href="indexcff1.html?p=1" class="btn btn-small btn-shadow"><span>Learn More</span></a>
							               </footer> -->
							           	</article>
							         </div>
							      </section>
							   </div>
								<div class="col-sm-6">
							      <section class="box box-brown widget-adopt-slider">
							      	<div class="animal-lizard-right"></div>
							      	<div class="box-header" style="background-color: #c59140">
							      		<h3 class="entry-title" style="color:#ffffff;text-align:center !important"> Activate Your Dragon Bank NOW!</h3>

							      	</div>
							      	<div class="box-content">
							      		<article class="post clearfix">
							      			<form class="form-horizontal default-form access-block" method="post" action="/new/signup/" role="form">								      			
								      			<div class="form-group">
													<div class="">
														<p>ENTER YOUR ACCESS CODE</p>
														<input id="code" class="form-control" type="text" name="access_code" id="code" onchange="remove_validation_error(this.id)">
														<div id="error_code"> <?php echo form_error('code', '<div class="error">', '</div>'); ?></div>
													</div>
												</div>
												<div class="form-group">
													<div class="">
														<button class="btn btn-order btn-order-xs btn-primary next-step" type="submit">
														Activate Your Dragon Bank NOW!
															<div class="glare"></div>
														</button>
													</div>
												</div>	
							      			</form>
							      		</article>
							      	</div>
							        
								   </section>
							  	</div>
								<div class="clearfix"></div>
							<!--		<div class="col-md-6">
								   <section class="box box-small widget-link ">
								      <div class="box-header">
								          <a href="index8419.html?faqs=faq"><span><em>Ask</em><strong>a vet</strong></span></a>
								      </div>
								      <div class="box-content with-thumbnail">
								          <span class="box-thumbnail"><img src="<?php echo base_url();?>assets/img/thumb-9.jpg" alt=""></span>
								      </div>
								      <div class="clearfix"></div>
								   </section>
								</div>
								<div class="col-md-6">
							     	<section class="box box-small widget-link box-red">
							         <div class="box-header">
							             <a href="index30c2.html?page_id=172"><span><em>Make</em><strong>an apointment</strong><sub>to your vet</sub></span></a>
							         </div>
							         <div class="box-content with-thumbnail">
							             <span class="box-thumbnail"><img src="<?php echo base_url();?>assets/img/mini-reservation.jpg" alt=""></span>
							         </div>
							         <div class="clearfix"></div>
							     	</section>
								</div>
								<div class="clearfix"></div>
								-->
									
							<!--	<div class="col-md-6 oder-container">
								   <section class="box box-small widget-link dragon-block">
								      <div class="box-header">
								          <a href="#loginmodal" id="modaltrigger"><span><h2>MY</h2><p class="bank">DRAGON</p><h2>BANK</h2></span></a>
								      </div>
								      <div class="box-content with-thumbnail  with-thumbnail_1">
								          <img src="<?php echo base_url();?>assets/img/img02.png" alt=""> 
								      </div>
								      <div class="clearfix"></div>
								   </section>
								</div>
								<div class="col-md-6 money-container">
							     	<section class="box box-small widget-link box-red dragon-block dragon-block-2">
							         <div class="box-header box-header_1">
							             <a href="index30c2.html?page_id=172"><span> <img src="<?php echo base_url();?>assets/img/star-new.png" alt=""><em>$19.99</em>--><!-- <strong>19,99</strong> --><!--</span></a>
							         </div>
							         <div class="box-content with-thumbnail">
							             <img src="<?php echo base_url();?>assets/img/img01.png" alt="">
							         </div>
							         <div class="clearfix"></div>
							     	</section>
								</div>
								<div class="clearfix"></div>-->
								
								<div class="col-sm-6">
							      <section class="box widget-services-slider">
							      	<div class="animal-dog-left"></div>
							      	<div class="box-header" style="background-color: #72a5e6;text-align:center;white-space:nowrap">
							            <a href="http://www.dragonbank.com/how" style="display:none" target="_blank" class="badge pull-right" title="View all Services">How It Works</a>
							            <h3 class="title">Why Kids Need Dragon Bank!</h3>
							        	</div>
										<div class="box-content">
							            <div id="services-slider25" class="frame-slider services-slider carousel slide fade-effect">
							               <div class="carousel-inner">
							               	<div class="item active">
							                     <!-- <div class="carousel-image"><img width="567" height="256" src="<?php //echo base_url();?>assets/img/thumb-37.jpg" class="attachment-post-thumbnail wp-post-image" alt="thumb-37" /></div> -->
							                     <div class="carousel-image"><a href="https://www.facebook.com/thedragonbank" target="_blank"><img src="http://www.dragonbank.com/new/assets/images/fb_dragon.png" border=0 style="width:310px !important" alt="Follow Us On Facebook" class="normal_logo"></a></div>
							                    <!--  <div class="carousel-content"><a href="index85c2.html?service=vaccinations">Vaccinations</a></div> -->
							                  </div>
							                  <!-- <div class="item ">
							                     <div class="carousel-image"><img width="567" height="256" src="<?php //echo base_url();?>assets/img/thumb-34.jpg" class="attachment-post-thumbnail wp-post-image" alt="thumb-34" /></div>
							                     <div class="carousel-content"><a href="index62d5.html?service=dental-care">Dental Care</a></div>
							                  </div>
							                  <div class="item ">
							                     <div class="carousel-image"><img width="567" height="256" src="<?php //echo base_url();?>assets/img/thumb-36.jpg" class="attachment-post-thumbnail wp-post-image" alt="thumb-36" /></div>
							                     <div class="carousel-content"><a href="indexce34.html?service=behaviour-training">Behaviour Training</a></div>
							                  </div>
							                  <div class="item ">
							                     <div class="carousel-image"><img width="567" height="256" src="<?php //echo base_url();?>assets/img/thumb-39.jpg" class="attachment-post-thumbnail wp-post-image" alt="thumb-39" /></div>
							                     <div class="carousel-content"><a href="index966f.html?service=nutrition">Nutrition</a></div>
							                  </div> -->
							               </div>
							               <!-- <ol class="carousel-indicators"><li data-target="#services-slider25" data-slide-to="0" class="active"></li><li data-target="#services-slider25" data-slide-to="1" class=""></li><li data-target="#services-slider25" data-slide-to="2" class=""></li><li data-target="#services-slider25" data-slide-to="3" class=""></li></ol> -->
							              <!--  <a class="carousel-control left" href="#services-slider25" data-slide="prev"></a>
							               <a class="carousel-control right" href="#services-slider25" data-slide="next"></a> -->
							           	</div>
							         </div>
							      </section>
							   </div>
								<div class="col-sm-6">
								   <section class="box widget-newsletter-large newsletter_subscription_box"><div class="animal-cat-right"></div><div class="box-header" style="background-color: #6ccad5; text-align:center"><h3 class="title">Real Savings....By Real Kids</h3></div>
										


										<div class="box-content">

										<div id="services-slider25" class="frame-slider  services-slider carousel slide fade-effect">
											<div class="carousel-inner">
												<div class="item active">
													<div class="carousel-image block-res">
														 <div class="price-block">
												         	<div style="padding: 90px 0 0;">
												         		<div class="price" style="width:130px; ">
														         <div  style="color:Red; font-size:32px;">$</div>
														         <div class="arange" id="show_amount" style="color:Red; font-size:32px; "></div>
														        </div>	
												         	</div>
												         </div>
													</div>
												</div>
											</div>
										</div>

								        <!--  <form method="post" action="#" class="newsletter_subscription_form">
								            <div class="field-text large buttoned">
								               <input type="email" name="newsletter" id="newsletter" class="newsletter_subscription_email inputField" placeholder="Your email here...">
								               <button class="newsletter_subscription_submit" type="submit" title="Subscribe"><i class="tficon-envelope"></i></button>
								            </div>

								            <input class="btn newsletter_subscription_submit" type="submit" name="newsletter-submit" value="Subscribe Now!">
								         </form> -->
								         
								         <!-- <img style="margin:auto;" src="<?php echo base_url();?>assets/img/image02.png"> -->
								         
								        



								         <div class="large_newsletter newsletter_subscription_messages before-text">
							               <div class="newsletter_subscription_message_success">
							                   Thank you for your subscription.
							               </div>
							               <div class="newsletter_subscription_message_wrong_email">
							                   Your email format is wrong!
							               </div>
							               <div class="newsletter_subscription_message_failed">
							                   Sad, but we couldn't add you to our mailing list ATM.
							               </div>
								         </div>
								      </div>
								   </section>
							   </div>
								<div class="clearfix"></div>

							
							</div>
						


		<div id="loginmodal" style="display:none;">
		<p id="message_flash"  style="display:none;"></p>
		<div id="loader"  style="display:none;"><img src="<?php echo base_url();?>assets/img/ajax-loader.gif"></div>
		<input type="button" name="loginbtn" id="close" class="btn btn-primary" value="X" tabindex="4">
		<h1>Request For Bank Code</h1> 
		<form id="ask_question" class="contact form-horizontal" name="ask_question" method="post" action="#">
			<div class="form-group">
				<label for="name"  class="col-sm-2 control-label">Name </label>
				<div class="col-sm-10">
					<input type="text" name="name" id="name" class="txtfield form-control" placeholder="Name" tabindex="1">			
				</div>
			</div>			
			<div class="form-group">
				<label for="email" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<input type="email" name="email" class="form-control" id="email" placeholder="Email">
				</div>
			</div>
			
			<div class="form-group">
				<label for="comments" class="col-sm-2 control-label">Comments</label>
				<div class="col-sm-10">				  
					<textarea class="form-control txtfield" name="comments" rows="3" style="resize:none"></textarea>  
				</div>
			  </div>			
		<div class="center"><input type="submit" name="loginbtn" id="loginbtn" class="btn btn-primary" value="Request Code" tabindex="3"></div>
		</form>
	</div>
			<script type="text/javascript">
 var count_amount = 5;
// $(document).ready(function(){
// 	alert('asdd');
//     setInterval(count, 2500);
// }); 

function count(){

	count_amount += .2;
	//setInterval(count, 2500);
	//alert('fsdf');
	var url = "<?php echo site_url('home/auto_increment');?>";

      $.post(url,{"count_amount":count_amount},function(data){
      $("#show_amount").html(data);
       
    });
	
}

</script>
<style>
#loader {
  bottom: 26px;
  display: block;
  margin-left: auto;
  margin-right: auto;
  position: absolute;
  right: 30px;
  text-align: center;
}
	
	
</style>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>  
  <script src="<?php echo base_url();?>assets/js/jquery.js"></script>
  <script type="text/javascript" charset="utf-8" src="http://designshack.net/tutorialexamples/modal-login-jquery/js/jquery.leanModal.min.js"></script>
   <script>
 function autoRefresh_div()
 {
     count();
     // location.reload();
     //window.location.reload();// a function which will load data from other file after x seconds
  }

  setInterval('autoRefresh_div()', 3000); // refresh div after 5 secs
            </script>

   
<script type="text/javascript"> 	
$(document).ready(function() {
 	$('.show_msg').fadeIn(1000);
 	$('.show_msg').css('background-color', '#DFF0D8').delay(6000).fadeOut(500) 		
 	$('.show_msg').css('color', '#70B770'); 
	});
 </script>  
<script type="text/javascript">
	$(function(){	  
	  $('#modaltrigger').leanModal({ top: 110, overlay: 0.45, closeButton: "#close" });
	});
	
	$(document).keyup(function(ev){
		if(ev.keyCode == 27)
			$("#lean_overlay").trigger("click");
	});
	
	$(document).ready(function() {		
	  $('#ask_question').submit(function(e){
			e.preventDefault();
			Data = $( "#ask_question" ).serialize();
			$('#loader').show();
			$.ajax({
				type: "POST",
				url: '<?php echo site_url();?>/home/ask_question',
				data: Data,				
				dataType: 'json',
				complete:function(data) {						
					obj = jQuery.parseJSON(data.responseText);				
					$('#loader').hide();
					$('#message_flash').html(obj.message);
					$('#message_flash').fadeIn('slow').delay(1000).fadeOut('slow',function() { if(obj.response == 'true') $("#lean_overlay").trigger("click");});
					
						
				}
			});
		});
	  });
</script>
