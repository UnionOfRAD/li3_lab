<?php

namespace li3_lab\extensions\helper;

class Maintainer extends \lithium\template\Helper {

	public function render($maintainers) {
		$form = $this->_context->helper('Form');
		$fieldset = array();
		$defaults = array('name' => null, 'email' => null, 'website' => null);
		$maintainers = (is_object($maintainers)) ? $maintainers->data() : array($defaults);

		foreach ($maintainers as $key => $data) {
			$data = array_merge($defaults, (array) $data);
			$fields = array();

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