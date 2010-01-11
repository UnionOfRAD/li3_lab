<?php

namespace li3_lab\extensions\helper;

class Form extends \lithium\template\helper\Form {

	public function multi($name, $fields = array(), $options = array()) {
		$defaults = empty($fields) ? array($name => null) : array_flip($fields);
		$data = $this->_binding->data($name);
		$data = is_object($data) ? $data->data() : array($defaults);
		$fieldset = array();

		foreach ($data as $key => $data) {
			$data = array_merge($defaults, (array) $data);
			$fields = array();

			foreach (array_keys($defaults) as $field) {
				$fields[] = join("\n", array(
					$this->label("{$name}.{$key}.{$field}", ucwords($field)),
					$this->text("{$name}[{$key}][{$field}]", $options)
				));
			}
			$fieldset[] = "<div class=\"{$name}\">" . join("\n", $fields) . "</div>";
		}
		return join("\n", $fieldset);
	}
}

?>