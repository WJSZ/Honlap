<script type="text/javascript">
$(document).keyup(function(e) {
  if (e.keyCode == 27) {
	document.location.href = "Galeria/Kepek/";
  }   // escape key = 27
});

jQuery(document).ready(function ($) {
	var options = {
		$FillMode: 1,
		$DragOrientation: 3,
		$ArrowKeyNavigation: true,
		$UISearchMode: 0, //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
		$ArrowNavigatorOptions: {
			$Class: $JssorArrowNavigator$,
			$ChanceToShow: 2,
			$AutoCenter: 2
		},
		$ThumbnailNavigatorOptions: {
			$Class: $JssorThumbnailNavigator$,
			$ChanceToShow: 2,        //[Required] 0 Never, 1 Mouse Over, 2 Always
			$Loop: 2,                //[Optional] Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind, default value is 1
			$SpacingX: 25,           //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
			$DisplayPieces: 6,      //[Optional] Number of pieces to display, default value is 1
		}
	};
	var jssor_slider1 = new $JssorSlider$('slider1_container', options);
	
	//responsive code begin
	//you can remove responsive code if you don't want the slider scales while window resizes
	function ScaleSlider() {
		var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
		if (parentWidth)
			jssor_slider1.$ScaleWidth(Math.min(parentWidth, 920));
		var parentHeight = jssor_slider1.$Elmt.parentNode.clientHeight;
		if (parentHeight)
			jssor_slider1.$ScaleHeight(Math.min(parentHeight, 600));
		else
			window.setTimeout(ScaleSlider, 30);
	}
	ScaleSlider();

	$(window).bind("load", ScaleSlider);
	$(window).bind("resize", ScaleSlider);
	$(window).bind("orientationchange", ScaleSlider);
	//responsive code end
});
</script>

<div style="position:fixed; top:0; left:0; background-color: #000; filter:alpha(opacity=40); opacity:.4; width: 100%; height:100%; z-index:1"></div>

<div style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:1000">
<a href="Galeria/Kepek/" style="position:fixed; top:0; right:0;"><img src="pic/x.png"></a>
<!-- Jssor Slider Begin -->
<div id="slider1_container" style="margin:0 auto; position: relative; width:920px; height:920px; overflow: hidden;">
	<!-- Loading Screen -->
	<div u="loading" style="position: absolute; top: 0px; left: 0px;">
		<div style="position: absolute; display: block;
			background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
		</div>
		<div style="position: absolute; display: block; background: url(pic/loading_spinner.gif) no-repeat center center;
			top: 0px; left: 0px;width: 100%;height:100%;">
		</div>
	</div>

	<!-- Slides Container -->
	<div u="slides" id="slider1_slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width:920px; height:920px; overflow: hidden;">

		<?=$kepek?>

	</div>
<!-- Slides Container End -->
	<!-- Arrow Navigator Skin Begin -->
	<style type="text/css">
	/* jssor slider ARROW navigator skin 19 css */
	/*
	.jssora19l              (normal)
	.jssora19r              (normal)
	.jssora19l:hover        (normal mouseover)
	.jssora19r:hover        (normal mouseover)
	.jssora19ldn            (mousedown)
	.jssora19rdn            (mousedown)
	*/
	.jssora19l, .jssora19r, .jssora19ldn, .jssora19rdn
	{
		position: absolute;
		cursor: pointer;
		display: block;
		background: url(style/JssorSlider/img/a19.png) no-repeat;
		overflow:hidden;
	}
	.jssora19l { background-position: -5px -35px; }
	.jssora19r { background-position: -65px -35px; }
	.jssora19l:hover { background-position: -125px -35px; }
	.jssora19r:hover { background-position: -185px -35px; }
	.jssora19ldn { background-position: -245px -35px; }
	.jssora19rdn { background-position: -305px -35px; }
	</style>
	<span u="arrowleft" class="jssora19l" style="width: 50px; height: 50px; top: 123px; left: 0px;"></span>
	<span u="arrowright" class="jssora19r" style="width: 50px; height: 50px; top: 123px; right: 0px"></span>
	<!-- Arrow Navigator Skin End -->
	
	<!-- ThumbnailNavigator Skin Begin -->
	<style type="text/css">
	/* jssor slider THUMBNAIL navigator skin 08 css */
	/*
	.jssort08 .p            (normal)
	.jssort08 .p:hover      (normal mouseover)
	.jssort08 .pav          (active)
	.jssort08 .pav:hover    (active mouseover)
	.jssort08 .pdn          (mousedown)
	*/
	.jssort08 .i
	{
		position:absolute;
		top: 0px;
		left: 0px;
		width: 120px;
		height: 90px;
		filter: alpha(opacity=80);
		opacity: .8;
	}
	.jssort08 .p:hover .i, .jssort08 .pav:hover .i
	{
		filter: alpha(opacity=100);
		opacity: 1;
	}
	.jssort08 .o
	{
		position: absolute;
		top:0px;
		left:0px;
		width:112px;
		height:82px;
		
		border: 4px solid #000;
		
		transition: border-color .6s;
		-moz-transition: border-color .6s;
		-webkit-transition: border-color .6s;
		-o-transition: border-color .6s;
	}
	* html .jssort08 .o
	{
		/* ie quirks mode adjust */
		width /**/: 100px;
		height /**/: 75px;
	}
	.jssort08 .pav .o, .jssort08 .p:hover .o
	{
		border-color: #fff;
	}
	.jssort08 .pav:hover .o
	{
		border-color: #0099FF;
	}
	.jssort08 .p:hover .o
	{
		transition: none;
		-moz-transition: none;
		-webkit-transition: none;
		-o-transition: none;
	}
	</style>
	<div u="thumbnavigator" class="jssort08" style="position: absolute; width: 920px; height: 100px; left: 0px; bottom: 0px; overflow: hidden;">
	<div style=" background-color: #000; filter:alpha(opacity=40); opacity:.4; width: 100%; height:100%;"></div>
	<!-- Thumbnail Item Skin Begin -->
		<div u="slides" style="cursor: move;">
			<div u="prototype" class="p" style="position: absolute; width: 120px; height: 90px; top: 0; left: 0;">
				<div u="thumbnailtemplate" class="i" style="position:absolute;"></div>
				<div class="o">
				</div>
			</div>
		</div>
		<!-- Thumbnail Item Skin End -->
	</div>
	<!-- ThumbnailNavigator Skin End -->
</div>
<!-- Jssor Slider End -->

</div>