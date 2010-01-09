function add() {
	var template = maintainer_template;
	var newdiv = template.replace(/XXX/g, ""+maintainer_count);
	$("#mm").append(newdiv);
	maintainer_count++;
	return false;
}

function remove(div) {
	$(div).parent().remove();
	return false;
}