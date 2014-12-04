$(document).ready(function(){
	changeAction();
});

function submitGamelog(){
	this.changeAction();
}

function changeAction(){
	if(document.getElementById("gamelog-type-element") != undefined){
		var logTypes = document.getElementById("gamelog-type-element").getElementsByTagName("input");
		for(var i = 0; i < logTypes.length; i++){
			if(logTypes[i].checked){
				document["player-date-form"].action = "/" + logTypes[i].value + "/gamelog";
			}
		}
	}
}
