
$(document).ready(function(){var validator=$("#general").validate({rules:{title:"required",description:"required",},messages:{title:"Title is required",description:"Description is Required"},errorPlacement:function(error,element){if(element.is(":radio"))
error.appendTo(element.parent().next().next());else if(element.is(":checkbox"))
error.appendTo(element.next());else
error.appendTo(element.parent().next());},submitHandler:function(){},success:function(label){label.html(" ").addClass("checked");}});});