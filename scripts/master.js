/*page preparations*/
function prepare(){
	/* Hovers */
	$("#nav_buttons li").mouseenter(function(){
		$(this).css("background-color", "black");
	})
	$("#nav_buttons li").mouseleave(function(){
		$(this).css("background-color", "");
	})
	
	$("#container img").mouseenter(function(){
		$(this).css("background-color", "black");
	})
	$("#container img").mouseleave(function(){
		$(this).css("background-color", "");
	})
	
	/* password strength meter*/
	var password = $("#signup_form #password");
		
	if(password.length)
		password.strength();
}

function delayRedirectFront(redirect){
	redirect = redirect || "main";
    window.setTimeout(function () {
        location.href = redirect;
    }, 5000);
}

function vote(points, id){
	var xmlhttp;
	xmlhttp=new XMLHttpRequest();
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			if(xmlhttp.responseText == "true"){
				var change = 1;
				if(points == 1){
					$("#plus").attr("disabled", "disabled");
					if($("#minus").is("[disabled]")){
						change = 2;
						$("#minus").removeAttr("disabled");
					}
				}
				else{
					$("#minus").attr("disabled", "disabled");
					if($("#plus").is("[disabled]")){
						change = 2;
						$("#plus").removeAttr("disabled");
					}
				}
				$("#points").val(parseInt($("#points").val()) + (points * change));
			}
			else
				alert(xmlhttp.responseText);
		}
	}
	xmlhttp.open("GET","../main/vote/"+id +"/"+points,true);
	xmlhttp.send();
}

function confirm_delete(id, type){
	var types = ["image", "comment", "user"]
	var r = confirm("Are you sure you want to delete this " + types[type] + "?");
	if (r == true) 
		location.href = "../delete/index/"+type+"/"+id;
}
