/**
 * A plugin to create multiple lists
 *
 * @copyright     Copyright 2009, Union of Rad, Inc. (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
(function($) {
	$.fn.input_list = function(settings) {
		var className = $(this).attr("class");
		var config = {
			'before': '<button class="remove">X</button>',
			'after': '',
			'template': this,
			'addLabel': 'add ' + className
		};

		if (settings) $.extend(config, settings);

		var count = 0;
		this.after('<a href="#add-' + className + '" id="add-' + className + '">'
			+ config.addLabel + '</a>'
		);

		$('#add-' + className).click(function() {
			var fieldset = config.template.clone();
			fieldset.html(fieldset.html().replace(/0/g, ++count));
			$(fieldset).prepend(config.before);
			$(fieldset).append(config.after);
			$(this).before(fieldset);
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
		return this;
	};
})(jQuery);