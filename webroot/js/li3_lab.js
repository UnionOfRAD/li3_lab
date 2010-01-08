function add() {
	var template = maintainer_template;
	var newdiv = template.replace(/XXX/g, ""+maintainer_count);
	$("div#mm").append(newdiv);
	maintainer_count++;
	return false;
}