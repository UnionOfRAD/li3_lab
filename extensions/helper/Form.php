<?php

namespace li3_lab\extensions\helper;

class Form extends \lithium\template\helper\Form {

	public function multi($name, $fields = array(), $options = array()) {
		$defaults = empty($fields) ? array($name => null) : array_flip($fields);
		$data = $this->_binding->data($name);
		$data = is_object($data) ? $data->data() : $data;
		$default = null;

		if (empty($data)) {
			$data = array($defaults);
			$default = false;
		}
		$fieldset = $inputs = array();

		if (empty($fields)) {
			$inputs[] = $this->label($name, ucwords($name));
			foreach ($data as $key => $value) {
				$value = isset($default) ? $default : $value;
				$inputs[] = $this->text("{$name}[{$key}]", $options + compact('value'));
			}
			$fieldset[] = "<div class=\"{$name}\">" . join("\n", $inputs) . "</div>";
			return join("\n", $fieldset);
		}

		foreach ($data as $key => $fields) {
			foreach ((array) $fields as $field => $value) {
				$value = isset($default) ? $default : $value;
				$inputs[] = join("\n", array(
					$this->label("{$name}.{$key}.{$field}", ucwords($field)),
					$this->text("{$name}[{$key}][{$field}]", $options + compact('value'))
				));
			}
			$fieldset[] = "<div class=\"{$name}\">" . join("\n", $inputs) . "</div>";
		}
		return join("\n", $fieldset);
	}
}

?>