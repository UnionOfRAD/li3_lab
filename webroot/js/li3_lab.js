li3Lab = {
	maintainers: function () {
		this.count = 0;
		$('.maintainer').prepend('<button class="remove">X</button>');
		this.template = $('.maintainer').html();
		$('#add-maintainer').click(function() {
			var maintainer = '<div class="maintainer">' +
				li3Lab.template.replace(/0/g, ++li3Lab.count) +
				'</div>';
			$("#maintainers").append(maintainer);
			$('.remove').click(function() {
				$(this).parent().remove();
				return false;
			});
			return false;
		});
		$('.remove').click(function() {
			$(this).parent().remove();
			return false;
		});

	}
}


