<?php

namespace li3_lab\extensions\helper;

use \lithium\template\helper\Form;

class Maintainer extends \lithium\template\Helper {

	public function __construct($config = array()) {
		parent::__construct($config);
		$this->form = new Form($config);
	}

	public function render($counter = 0, $d = null) {
		if ($d) {
			$data['name'] = ($d->name)?: null;
			$data['email'] = ($d->email)?: null;
			$data['website'] = ($d->website)?: null;
		} else {
			$data = array('name' => null, 'email' => null, 'website' => null);
		}
		$ret = '<div class="maintainer">';
		$ret .= '<button onclick="javascript:remove(this); return false;">X</button>';
		$ret .= $this->form->label('maintainers.' . $counter . '.name', 'Name');
		$ret .= $this->form->text('maintainers[' . $counter . '][name]',
			array('value' => $data['name']));
		$ret .= $this->form->label('maintainers.' . $counter . '.email', 'Email');
		$ret .= $this->form->text('maintainers[' . $counter . '][email]',
			array('value' => $data['email']));
		$ret .= $this->form->label('maintainers.' . $counter . '.website', 'Website');
		$ret .= $this->form->text('maintainers[' . $counter . '][website]',
			array('value' => $data['website']));
		$ret .= '</div>';
		return $ret;
	}

	public function template() {
		$ret = '<div class="maintainer">';
		$ret .= '<button onclick="javascript:remove(this); return false;">X</button>';
		$ret .= $this->form->label('maintainers.XXX.name', 'Name');
		$ret .= $this->form->text('maintainers[XXX][name]');
		$ret .= $this->form->label('maintainers.XXX.email', 'Email');
		$ret .= $this->form->text('maintainers[XXX][email]');
		$ret .= $this->form->label('maintainers.XXX.website', 'Website');
		$ret .= $this->form->text('maintainers[XXX][website]');
		$ret .= '</div>';
		return $ret;

	}
}

?>