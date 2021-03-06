var retryInterval=1;
function enqueueWidget(e, timeout)
{
	if(!timeout)
		timeout=e.getAttribute("data-timeout");
	setTimeout(function(){reloadWidget(e)}, timeout*1000);
	e.addEventListener("click", function(){reloadWidget(this)});
}
function reloadWidget(e)
{
	var widget=e.getAttribute("data-widget");
	var section=e.getAttribute("data-section");
	var xhr=new XMLHttpRequest();
	xhr.addEventListener("load", function() {
		var newE=new DOMParser().parseFromString(this.response, "text/html").body.childNodes[0];
		e.parentNode.replaceChild(newE, e);
		enqueueWidget(newE);
	});
	xhr.addEventListener("error", function() {
		enqueueWidget(e, retryInterval);
	});
	xhr.open("GET", "?widget="+widget+"&section="+section);
	e.classList.add("pending");
	xhr.send();
}
(function(){
	var widgets=document.getElementsByClassName("widget");
	for(var i=0; i<widgets.length; i++) {
		enqueueWidget(widgets[i], 0);
	}
})();
