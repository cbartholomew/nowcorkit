
function Effects(config){var divs=[];divs=config.divs;function runEffect(){for(var i=0;i<divs.length;i++)
$("#"+divs[i]).removeAttr("style").hide().fadeIn("fast");};runEffect();}