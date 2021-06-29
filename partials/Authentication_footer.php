		<script src="./assets/js/jquery-3.1.1.min.js" ></script>
        <script src="./assets/js/uikit.min.js" ></script>
		<script src="./assets/js/uikit-icons.min.js" ></script>		
		<script src="./assets/js/bootstrap.min.js"></script>
		<script src="./assets/js/Chart.min.js"></script>
		<script src="./assets/js/script.js"></script>
		<script src="./assets/js/Timeis.js"></script>
		<script src="./assets/js/Authentication.js"></script>
		<script src="./assets/js/jquery.maskedinput.js"></script>
		<script type="text/javascript">
		
			$(document).ready(function() {
				
				$('body').css('height','100%').fadeIn(1000);
				$("#contact").mask("99 99 99 99",{placeholder:" "});    	
			});

    		//Rotation du logo
			var AnimatedLogo = setInterval(function(){
				
				var elem = $(".cube");

				$({deg: 0}).animate({deg: 1800}, {
					duration: 2000,
					step: function(now){
						elem.css({
							transform: "rotate(" + now + "deg)"
						});
					}
				});
				
			}, 10000);
	    </script>
	</body>
</html>