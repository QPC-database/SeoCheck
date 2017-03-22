(function(window, document, $) {

	var $form = $('#add-site-form');
	if ($form.length === 0) return;

	var $button = $form.find('button');

	var $alert = $('.alert-response');

	var failed = function (err) {
		$button[0].disabled = false;
		$alert.removeClass('alert-info').addClass('alert-danger').html('<strong>Woops!</strong> There was an error: ' + err.status + ' ' + err.statusText);
	};

	var success = function () {
		$button[0].disabled = false;
		$form.trigger('reset');
		$alert.removeClass('alert-info').addClass('alert-success').html('<strong>Sweet!</strong> The site has been added to the list.');
	};

	$form.on('submit', function(e) {
		e.preventDefault();
		var data = $form.serialize();
		if($('#siteName').val() !== '') {
			$button[0].disabled = true;
			$.ajax({
				url: './tasks.php?cron=addSite',
				data: data,
				method: 'POST',
			})
			.done(function(data, textStatus, jqXHR) {
				if (jqXHR.status === 200) success();
				else failed(data, textStatus, jqXHR);
			})
			.fail(function(err) {
				failed(err);
			});
		} else {
			$alert.removeClass('alert-info').addClass('alert-warning').html('<strong>Check the form!</strong> Please make sure all fields are filled in.');
		}
	});

}(window, document, jQuery));
