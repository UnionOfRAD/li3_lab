li3Lab = {
	maintainers: function () {
		this.count = 0;
		this.template = $('.maintainer').html();
		$('#add-maintainer').click(function() {
			var maintainer = li3Lab.template.replace(/0/g, li3Lab.count++);
			$("#maintainers").append(maintainer);
			return false;
		});
		$('.remove').click(function() {
			$(this).parent().remove();
			return false;
		});
	}
}