(function(window, document, $) {

	var $form = $('#add-site-form');
	if ($form.length === 0) return;

	var $button = $form.find('button');

	var failed = function () {
		$button[0].disabled = false;
		alert('Error adding ting, check console');
		console.log(arguments);
	};

	var success = function () {
		$button[0].disabled = false;
		$form.find('input')
			.each(function() {
				var $this = $(this);
				$this.val('');
			});
		alert('Added site');
	};

	$form.on('submit', function(e) {
		$button[0].disabled = true;
		var data = $form.serialize();
		e.preventDefault();
		$.ajax({
			url: '/tasks.php?cron=addSite',
			data: data,
			method: 'POST',
		})
		.done(function(data, textStatus, jqXHR) {
			if (jqXHR.status === 200) success();
			else failed(data, textStatus, jqXHR);
		})
		.fail(function() {
			failed(arguments);
		});
	});

}(window, document, jQuery));
