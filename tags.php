
	<link rel="stylesheet" type="text/css" href="./tags/src/jquery.tagsinput.css" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="./tags/src/jquery.tagsinput.js"></script>
        <script type="text/javascript" src="assets/js/theme.js"></script>
	<!-- To test using the original jQuery.autocomplete, uncomment the following -->
	<!--
	<script type='text/javascript' src='http://xoxco.com/x/tagsinput/jquery-autocomplete/jquery.autocomplete.min.js'></script>
	-->
	<script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js'></script>
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/themes/start/jquery-ui.css" />
	<link rel="stylesheet" type="text/css" href="./tags/src/jquery.autocomplete.css" />


	<script type="text/javascript">

		$(function() {

			$('#tags').tagsInput({
				width: 'auto',

				autocomplete_url:'get_tags.php' // jquery ui autocomplete requires a json endpoint
			});

		});

	</script>
