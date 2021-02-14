$(function () {
  $('#components_table').DataTable({
    "paging": false,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": false,
    "autoWidth": false,
  });
});

$(function () {
  $('#tags_table').DataTable({
    "paging": false,
    "lengthChange": true,
    "searching": true,
    "ordering": true,
    "info": false,
    "autoWidth": false,
  });
});

$(document).ready(function(){
	afterstyler();
});
function afterstyler(){
	var filter,child,input;
	filter = $('.dataTables_filter input');
	filter.addClass("form-control-sm p-1 border border-success ");
}

$('#components_table  tbody tr button').on('click',function(){
	var add_display = document.getElementById('added-components');
	var parent = this.parentElement.parentElement;

	var img,name,key;

	img = parent.children[0].innerHTML;
	name = parent.children[1].children[0].children[0].innerText;
	key = this.name;
	//append Dom Element
	var item = '<span class="badge badge-md badge-primary m-1">'+name+'<input hidden value="'+key+'"> <i class="mdi mdi-close p-1" id="item-remove"></i></span>';
    add_display.innerHTML += item;

    //Add to value input
    var val_input = document.getElementById('items-values');
    if(val_input.value !=''){
    	//get current value
    	var current = val_input.value+"/";
    	//add new value to  current
    	var v = current + key;
    	val_input.value = v;
    }else{
    	val_input.value = key;
    }
});


$('#tags_table  tbody tr button').on('click',function(){
	var add_display = document.getElementById('added-components');
	var parent = this.parentElement.parentElement;
	var tag,key;
	tag = parent.children[0].children[0].innerText;

	key = this.name;
	//write to the tags list
	var tl = document.getElementById('tag-list-input');

	if(tl.value !==''){
		var current = tl.value;
		var val = current+"/"+key;
		tl.value = val;
	}else{
		tl.value = key;
	}
	//append Dom Element
	var item = '<span class="badge badge-md badge-primary m-1">'+tag+'  <i class="mdi mdi-tag p-1"></i></span>';
    document.getElementById('tag-list').innerHTML += item;
});

/////////////////////

//////////

////
localStorage.removeItem('component_dimensions');
//Adding item Dimemsion or geometry
let DIM_NAME,DIM_VAL,ADD_DIM;
DIM_NAME = 	document.getElementById('Dim_name');
DIM_VAL = 	document.getElementById('Dim_value');
ADD_DIM = document.getElementById('add_dimension');

$(ADD_DIM).on('click',function(){

	if(DIM_VAL.value==""){
		DIM_VAL.parentElement.children[0].innerHTML = "Empty value not allowed";
	}else{
		DIM_VAL.parentElement.children[0].innerHTML = "value :";
	}
	if(DIM_NAME.value==""){
		DIM_NAME.parentElement.children[0].innerHTML = "Empty name not allowed";
	}else{
		DIM_NAME.parentElement.children[0].innerHTML = "Name :";
	}

	//variables
	var dim,name,value;
	name = DIM_NAME.value;
	value = DIM_VAL.value;

	dim = {};

	if(JSON.parse(localStorage.getItem('component_dimensions')) !== null){
		var ls_dim = JSON.parse(localStorage.getItem('component_dimensions'));
		ls_dim[name] = value;
		localStorage.setItem('component_dimensions',JSON.stringify(ls_dim));
	}else{
		dim[name] = value;
		if(name!=='' & value!==''){
			localStorage.setItem('component_dimensions',JSON.stringify(dim));
		}
	}
	DIM_NAME.value = '';
	DIM_VAL.value = '';
	document.getElementById('dimensions_display').value = localStorage.getItem('component_dimensions');
	document.getElementById('create-project').setAttribute('type','submit');
});