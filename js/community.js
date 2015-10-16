function togglePost(){
	var val = this.id.substring('post-title'.length);
	if (document.getElementById('full-post' + val).style.display == 'none'){
		expandPost(this);
	} else {
		shrinkPost(this);
	}
}

function expandPost(el){
	var val = el.id.substring('post-title'.length);
	document.getElementById('full-post' + val).style.display = 'initial';
	document.getElementById('preview' + val).style.display = 'none';

	var li = document.getElementsByClassName('headers');
	for(i = 0; i < li.length; i++){
		var val2 = li[i].id.substring('post-title'.length);
		if(val != val2){
			shrinkPost(li[i]);
		}
	}
}

function shrinkPost(el){
	var val = el.id.substring('post-title'.length);
	document.getElementById('full-post' + val).style.display = 'none';
	document.getElementById('preview' + val).style.display = 'initial';
}

var els = document.getElementsByClassName('headers');
for(i = 0; i < els.length; i++){
	els[i].onclick = togglePost;
}
