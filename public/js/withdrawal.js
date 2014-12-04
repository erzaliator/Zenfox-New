function proWithdrawal(tabNo){
	switch(tabNo){
		case 0:
			/*var identitiFication = document.getElementById("identityverification").getElementsByTagName("input");
			for(var i = 0; i < identitiFication.length; i++){
				console.log(identitiFication[i].value);
			}*/
			var identitiFication = document.getElementById("fileField");
			var file = identitiFication.files[0];

		    console.log("File name: " + file.fileName);
		    console.log("File size: " + file.fileSize);
		    console.log("Binary content: " + file.getAsBinary());
		    console.log("Text content: " + file.getAsText(""));
			document.getElementById("identityverification").style.display = "none";
			document.getElementById("withdraw").style.display = "block";
			break;
		case 1:
			document.getElementById("withdraw").style.display = "none";
			document.getElementById("WITHDRAWAL-REQUEST").style.display = "block";
			break;
	}
}