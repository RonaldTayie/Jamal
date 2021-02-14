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
		console.log(localStorage.getItem('component_dimensions'));
	}else{
		dim[name] = value;
		if(name!=='' & value!==''){
			localStorage.setItem('component_dimensions',JSON.stringify(dim));
		}
	}
	DIM_NAME.value = '';
	DIM_VAL.value = '';
	document.getElementById('dimensions_display').value = localStorage.getItem('component_dimensions');


});