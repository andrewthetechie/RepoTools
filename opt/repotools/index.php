<?php
	
	include('includes/php/header.php');
	include('includes/php/htmlHeader.php');
	?>	<body>
	<div class="container">
	
	<?
	if(!$userStatus){
?>

	<form action="login.php" method="post" name="login" target="_self" 
		id="login" class="form-horizontal">
		<h3><? echo $status; ?></h3>
	<fieldset>

	<!-- Form Name -->
	<legend>Login</legend>

	<!-- Text input-->
	<div class="control-group">
	  <label class="control-label" for="username">Username</label>
	  <div class="controls">
		<input id="username" name="username" type="text" placeholder="username"
			class="input-large" required="">
		
	  </div>
	</div>

	<!-- Password input-->
	<div class="control-group">
	  <label class="control-label" for="password">Password</label>
	  <div class="controls">
		<input id="password" name="password" type="password" 
			placeholder="**********" class="input-large" required="">
		
	  </div>
	</div>

	<!-- Button -->
	<div class="control-group">
	  <label class="control-label" for="submit"></label>
	  <div class="controls">
		<button id="submit" name="submit" class="btn btn-info">Login</button>
	  </div>
	</div>

	</fieldset>
	</form>


<? 
	}//end user not logged in, show login form
	
	else{

	include('includes/php/navbar.php'); 


?>
	<body>
				<script type="text/javascript" charset="utf-8">
			/* Default class modification */
			$.extend( $.fn.dataTableExt.oStdClasses, {
				"sSortAsc": "header headerSortDown",
				"sSortDesc": "header headerSortUp",
				"sSortable": "header"
			} );

			/* API method to get paging information */
			$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
			{
				return {
					"iStart":         oSettings._iDisplayStart,
					"iEnd":           oSettings.fnDisplayEnd(),
					"iLength":        oSettings._iDisplayLength,
					"iTotal":         oSettings.fnRecordsTotal(),
					"iFilteredTotal": oSettings.fnRecordsDisplay(),
					"iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
					"iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
				};
			}

			/* Bootstrap style pagination control */
			$.extend( $.fn.dataTableExt.oPagination, {
				"bootstrap": {
					"fnInit": function( oSettings, nPaging, fnDraw ) {
						var oLang = oSettings.oLanguage.oPaginate;
						var fnClickHandler = function ( e ) {
							e.preventDefault();
							if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
								fnDraw( oSettings );
							}
						};

						$(nPaging).addClass('pagination').append(
							'<ul>'+
								'<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
								'<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
							'</ul>'
						);
						var els = $('a', nPaging);
						$(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
						$(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
					},

					"fnUpdate": function ( oSettings, fnDraw ) {
						var iListLength = 5;
						var oPaging = oSettings.oInstance.fnPagingInfo();
						var an = oSettings.aanFeatures.p;
						var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

						if ( oPaging.iTotalPages < iListLength) {
							iStart = 1;
							iEnd = oPaging.iTotalPages;
						}
						else if ( oPaging.iPage <= iHalf ) {
							iStart = 1;
							iEnd = iListLength;
						} else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
							iStart = oPaging.iTotalPages - iListLength + 1;
							iEnd = oPaging.iTotalPages;
						} else {
							iStart = oPaging.iPage - iHalf + 1;
							iEnd = iStart + iListLength - 1;
						}

						for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
							// Remove the middle elements
							$('li:gt(0)', an[i]).filter(':not(:last)').remove();

							// Add the new list items and their event handlers
							for ( j=iStart ; j<=iEnd ; j++ ) {
								sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
								$('<li '+sClass+'><a href="#">'+j+'</a></li>')
									.insertBefore( $('li:last', an[i])[0] )
									.bind('click', function (e) {
										e.preventDefault();
										oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
										fnDraw( oSettings );
									} );
							}

							// Add / remove disabled classes from the static elements
							if ( oPaging.iPage === 0 ) {
								$('li:first', an[i]).addClass('disabled');
							} else {
								$('li:first', an[i]).removeClass('disabled');
							}

							if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
								$('li:last', an[i]).addClass('disabled');
							} else {
								$('li:last', an[i]).removeClass('disabled');
							}
						}
					}
				}
			} );

			/* Table initialisation */
			$(document).ready(function() {
				$('#repos').dataTable( {
					"sDom": "<'row'<'span8'l><'span8'f>r>t<'row'<'span8'i><'span8'p>>",
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_ records per page"
					}
				} );
			} );
		</script>
	<div class="container">
	<table cellpadding="0" cellspacing="0" border="0" class="bordered-table zebra-striped" id="repos">
	<thead>
		<tr>
			<th>Repos</th>
		</tr>
	</thead>
	<tbody>
	
	<?

		$repos = listRepos();

		for($i=0; $i<count($repos);$i++)
		{
			$current = $repos[$i];
			echo "<tr><td><a href='".SVNPATH."/$current' ";
			echo "target=_blank>$current</a></td></tr>";

		}
	
	
	
	include('includes/php/footer.php');
	}//end else
?>
