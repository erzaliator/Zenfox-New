function AnalyticsForms() 
		{
				
				var len = document.getElementById("AnalyticsForms").networkorfrontend.length;
				
				for(var i = 0; i < len; i++){
					if(document.getElementById("AnalyticsForms").networkorfrontend[i].checked)
						{
							var value = document.getElementById("AnalyticsForms").networkorfrontend[i].value;
							if(value == 'Frontend'){
								document.getElementById("frontend").style.display = "block";
								document.getElementById("frontend-label").style.display = "block";

								document.getElementById("affiliate").style.display = "none";
								document.getElementById("affiliate-label").style.display = "none";

								document.getElementById("tracker").style.display = "none";
								document.getElementById("tracker-label").style.display = "none";
						
							}
							else if(value == 'Affiliate'){
								document.getElementById("frontend").style.display = "none";
								document.getElementById("frontend-label").style.display = "none";

								document.getElementById("affiliate").style.display = "block";
								document.getElementById("affiliate-label").style.display = "block";

								document.getElementById("tracker").style.display = "none";
								document.getElementById("tracker-label").style.display = "none";
						
							}
							else if(value == 'Tracker'){
								document.getElementById("frontend").style.display = "none";
								document.getElementById("frontend-label").style.display = "none";

								document.getElementById("affiliate").style.display = "none";
								document.getElementById("affiliate-label").style.display = "none";

								document.getElementById("tracker").style.display = "block";
								document.getElementById("tracker-label").style.display = "block";
						
							}
							else{
								document.getElementById("frontend").style.display = "none";
								document.getElementById("frontend-label").style.display = "none";

								document.getElementById("affiliate").style.display = "none";
								document.getElementById("affiliate-label").style.display = "none";

								document.getElementById("tracker").style.display = "none";
								document.getElementById("tracker-label").style.display = "none";
							}
								
						}
				}
		}

function AnalyticsFrontendForms()
{
	document.getElementById("frontend").style.display = "block";
	document.getElementById("frontend-label").style.display = "block";
}

function PlayerHealthForms()
{
	document.getElementById("playertag-element").style.display = "block";
	document.getElementById("playertag-label").style.display = "block";
}

function HealthForms()
{
	var len = document.getElementById("HealthForm").health.length;
	
	for(var i = 0; i < len; i++){
		if(document.getElementById("HealthForm").health[i].checked)
			{
				var value = document.getElementById("HealthForm").health[i].value;
				if(value == 'SystemHealth'){
					document.getElementById("systemtag-element").style.display = "block";
					document.getElementById("systemtag-label").style.display = "block";

					document.getElementById("playertag-element").style.display = "none";
					document.getElementById("playertag-label").style.display = "none";

					document.getElementById("trackertag-element").style.display = "none";
					document.getElementById("trackertag-label").style.display = "none";
			
				}
				else if(value == 'PlayerHealth'){
					document.getElementById("systemtag-element").style.display = "none";
					document.getElementById("systemtag-label").style.display = "none";

					document.getElementById("playertag-element").style.display = "block";
					document.getElementById("playertag-label").style.display = "block";

					document.getElementById("trackertag-element").style.display = "none";
					document.getElementById("trackertag-label").style.display = "none";
			
				}
				else if(value == 'TrackerHealth'){
					document.getElementById("systemtag-element").style.display = "none";
					document.getElementById("systemtag-label").style.display = "none";

					document.getElementById("playertag-element").style.display = "none";
					document.getElementById("playertag-label").style.display = "none";

					document.getElementById("trackertag-element").style.display = "block";
					document.getElementById("trackertag-label").style.display = "block";
			
				}
				else{
					document.getElementById("systemtag-element").style.display = "none";
					document.getElementById("systemtag-label").style.display = "none";

					document.getElementById("playertag-element").style.display = "none";
					document.getElementById("playertag-label").style.display = "none";

					document.getElementById("trackertag-element").style.display = "none";
					document.getElementById("trackertag-label").style.display = "none";
				}
					
			}
	}
	
}

function HealthsubmitForms()
{
		if(!document.getElementById("HealthForm").health.length)
		{
			if(document.getElementById("HealthForm").health.checked)
			{
				document.getElementById("HealthForm").action = 	"/health/playerhealth";
			}
		}
		else
		{
			
			if(document.getElementById("HealthForm").health[0].checked)
			{
				document.getElementById("HealthForm").action = 	"/health/systemhealth";
			}
			if(document.getElementById("HealthForm").health[1].checked)
			{
				document.getElementById("HealthForm").action = 	"/health/playerhealth";
			}
			if(document.getElementById("HealthForm").health[2].checked)
			{
				document.getElementById("HealthForm").action = 	"/health/trackerhealth";
			}
		}
}