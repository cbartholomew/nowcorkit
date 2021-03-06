
function Menu(config)
{var param=config.param;var that=this;var page={'0':{id:'flyer_choice'},'1':{id:'flyer_manager'},'2':{id:'post'},'3':{id:'board_manager'}};var bar={'0':{id:'menu'},'1':{id:'help'},'2':{id:'user'},'3':{id:'logout'}};function set_page(pid)
{param=pid;};function request_page()
{$.ajax({url:page[param].id+".php",beforeSend:function(){$("#content").mask("loading...");},success:function(data){$("#content").unmask();that.clean();$("#content").html(data);}});return false;};function load_preferences()
{$.ajax({url:"update_registration.php",type:"post",beforeSend:function(){$("#content").mask("pulling...");},success:function(data){$("#content").unmask();$('#content').html(data);},error:function(data){$("#content").unmask();$("#content").html(data);}});return false;};function toolbar()
{var html='<span id="span_menu">';html+='<input type="radio" id="menu"      name="menu" /> <label for="menu">Menu</label>';html+='<input type="radio" id="help"   name="menu" />  <label for="help">Help</label>';html+='<input type="radio" id="user"   name="menu" />  <label for="user">Preferences</label>';html+='<input type="radio" id="logout"    name="menu" /> <label for="logout">Logout</label>';html+='</span>';$('#toolbar').html(html);$(function(){$("#span_menu").buttonset();});$('#'+bar[param].id).attr('checked',true);$('#logout').click(function(){window.location="logout.php";});$('#help').click(function(){that.help_modal();});$('#menu').click(function(){that.clean();});$('#user').click(function(){load_preferences();});return false;};this.get_toolbar=function()
{return toolbar();};this.get_menu_page=function(param)
{set_page(param);return request_page();};}
Menu.prototype.clean=function()
{$('#content').html("");$('#form_content').html("");};Menu.prototype.help_modal=function()
{$(function(){$.ajax({url:'help.php',type:'GET',success:function(data){$('#modal_help').html(data);},failure:function(){$('#modal_help').html("Problem loading content");}});});$("#modal_help").dialog({autoOpen:false,cache:false,modal:true,height:600,width:550,draggable:false,resizable:false,title:'Help Menu',});$("#modal_help").dialog("open");};