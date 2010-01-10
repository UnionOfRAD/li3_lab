<?php

namespace li3_lab\extensions\helper;


class Maintainer extends \lithium\template\Helper {

	public function render($maintainers) {
		$form = $this->_context->helper('Form');

		$defaults = array('name' => null, 'email' => null, 'website' => null);
		$fieldset = array();
		if (empty($maintainers)) {
			$maintainers = array($defaults);
		}
		foreach ($maintainers as $key => $data) {
			$data = array_merge($defaults, (array) $data);
			$fields = array('<button class="remove">X</button>');

			foreach (array_keys($defaults) as $field) {
				$fields[] = join("\n", array(
					$form->label("maintainers.{$key}.{$field}", ucwords($field)),
					$form->text("maintainers[{$key}][{$field}]", array(
						'value' => $data[$field]
					))
				));
			}
			$fieldset[] = '<div class="maintainer">' . join("\n", $fields) . '</div>';
		}
		return join("\n", $fieldset);
	}
}

?>