function initialize_page()
{
	$(document).ready(function(){
		$.getScript('js/menu.js', function(){	
			var m = new Menu({param:'0'});
		
			$(function(){
				$( "#selectable" ).selectable({
					selected: function(event, ui){ 
						if (ui.selected.id != "5") { m.clean(); }
						
						if(ui.selected.id)
							m.get_menu_page(ui.selected.id);
					}
				});
			});	
		});
	});	
};
function initialize_create_flyer()
{
	$(document).ready(function(){
		$.getScript('js/flyer.js', function(){
			var f = new Flyer({param:'0'});
			$(function(){                      
   				$("#text").click(function(ui){
					f.load_template($(this).attr("id2"));                    
					$("#flyer_info").html(flyer_info[$(this).attr("id")].description);					
				}); 
				
				$("#text_image").click(function(){   				
					f.load_template($(this).attr("id2"));     				
                    $("#flyer_info").html(flyer_info[$(this).attr("id")].description);	
				}); 
				
				$("#image").click(function(){
                     f.load_template($(this).attr("id2"));
					 $("#flyer_info").html(flyer_info[$(this).attr("id")].description);	       
				}); 			
			});
		});
	});
};
function initialize_flyer_manager(){
	$(document).ready(function(){
		$(function() {

			var mydivs = ["form_content", "content"];
			var fx = new Effects({divs: mydivs});

			// render middle html box
			$.post("flyer_manager_flyer_area.php", function(middleHtml){ 			
				$("#form_content").html(middleHtml);		
				$.getScript('js/flyer.js', function(){		

					$("#area_edit_radio").buttonset();		

					$('#area_edit').click(function() {
						if ($("#p_drop").attr("type") == "0") {
							$("#p_drop").html("Please click an item first!");
						}
						var f = new Flyer({param:$("#flyer_container").attr("type")});
						f.load_editor();
					});

					$('#area_remove').click(function() {
						if ($("#p_drop").attr("type") == "0") {
							$("#p_drop").html("Please click an item first!");
						}
						var f = new Flyer({param:$("#flyer_container").attr("type")});
						f.load_remover();
					});
				});							
			});	
		});	
	});	
}
function initialize_registration_update(){
	$(document).ready(function(){
		$(function() {
			var mydivs = ["updates"];
			var fx = new Effects({divs: mydivs});
			
			$("#btnUpdate").click(function(){ 			
					$.ajax({
				      	url:  "update_registration_info.php",
					   	type: 'post',
					   	data: {
								stateid: $("#state option:selected").val()
					   	},
				        success: function(data) {
							$("#updates").html(data);
						},
						error:   function(data) {

						}
					});
			});
		});
	});
}
function initialize_board_manager()
{
	$(document).ready(function(){
		var mydivs = ["form_content", "content"];
		var fx = new Effects({divs: mydivs});
		
		$.getScript('js/board.js', function(){
			var b = new Board({param:'create', page:''});
			$("#create_board").button().click(function(){
				return b.load_create();
			});
			$("#board_select").change(function(){
				return b.load_board();
			});
			$("#display_board").click(function(){
				b.board_manager('corkboard');
			});
			$("#remove_board").click(function(){
				b.board_manager('remove');
			});
		});
	});
};
function initialize_tab_manager()
{
	$(document).ready(function(){
		
		var mydivs = ["tabs"];
		var fx = new Effects({divs: mydivs});
		
		$.getScript('js/board.js', function(){
			var b = new Board({param:'create', page:''});
			$(function(){				
				$("#all").click(function(){
					b.update_post_filter($(this).val());
				});		
				$("#pending").click(function(){
					b.update_post_filter($(this).val());
				});
				$("#posted").click(function(){
					b.update_post_filter($(this).val());
				});
				$("#pps_posted").click(function(){
					b.update_post_filter($(this).val());
				});
				$("#notapproved").click(function(){
					b.update_post_filter($(this).val());
				});

				
			});
		});
	});
};
function initialize_cork_flyer()
{
	$(document).ready(function(){	
		var mydivs = ["form_content", "content"];
		var fx = new Effects({divs: mydivs});
			
		$.getScript('js/post.js', function(){	
			$("#form_content").load("post_secondary.php", function(){
				
				var p = new Post();
				$(function() {		
					/*render buttons*/
					$( "#add_button" ).button({
				        icons: {
				            primary: "ui-icon-plus"
				        },
					 	text: false
					});
					$( "#pps_button" ).button({
				        icons: {
				            primary: "ui-icon-notice"
				        },
					 	text: false
					});	
						
				
					/*attach button listeners*/		
					
					$("#add_button").click(function(){
						p.actions('post_to_location');				
					});
				
					$("#pps_button").click(function(){
						p.show_pps_info()		
					});
	
					$("#state").change(function(){
						p.location_update($(this).val());
					});
												
					$("#location").change(function(){
						p.maps_api($(this).val());
						p.load_table_entry($(this).val());
					});
					
					$("#form_content").unmask();
				});
			});			
		});
	});
	
};
function render_action_buttons(id)
{
	$(document).ready(function(){
		$.getScript('js/board.js', function(){	
			var b = new Board({param:'create', page:''});
			$(function() {
				// preview
				$( "#preview_" + id ).button({
			        icons: {
			            primary: "ui-icon-search"
			        },
				 label: "Preview",
				 text: false
				}),
				$("#preview_" + id ).click(function() {
					window.open('generate.php?flyerid=' + $('#preview_' + id).attr('name'),null,'height=600,width=800,status=no,toolbar=no,menubar=no,location=no');
				}),
				$( "#approve_" + id ).button({
			        icons: {
			            primary: "ui-icon-check"
			        },
				 label: "Approve",
				 text: false
				}),
				$("#approve_" + id).click(function() {
						b.post_manager('approve', id);
						var filter_id = $('input[name=filter]:checked', '#filters').val();
						b.update_post_filter(filter_id);
				}),
				$( "#remove_" + id ).button({
			        icons: {
			            primary: "ui-icon-minus"
			        },
				 label: "Remove",
				 text: false
				}),
				$("#remove_" + id).click(function() {			

						var m = new ModalDialog({
							div: "modal_dialog",
							title: "Problem Removing",
							height: "300",
							width: "300",
							text: "Can't remove flyer because its status is 'PPS - Posted'. Only the poster may remove."
						});

						var pps = b.post_manager('check_pps',id);			
						if (pps["is_pps"] == true) {m.open();}
						else 
						{
							b.post_manager('not_approve',id);
							var filter_id = $('input[name=filter]:checked', '#filters').val();
							b.update_post_filter(filter_id);
						}
				}),
				$( "#pps_" + id ).button({
			        icons: {
			            primary: "ui-icon-pin-s"
			        },
				 label: "Begin PPS",
				 text: false
				}),
				$("#pps_" + id ).click(function() {
						// make request to begin pps			
						var pps = b.post_manager('check_pps',id);	

						// prepare dialog
						var m = new ModalDialog({
							div: "modal_dialog",
							title: "Problem Adding PPS",
							height: "300",
							width: "300",
							text: "Can't enable PPS because you have no more slots avaliable. Please wait until a PPS Posted Flyer expires!"
						});	

						if (pps["is_max"] == true) { m.open(); }
						else if (pps["is_pps"] == true)
						{
							// reset the modal info
							m.setInfo({
								title: "Already PPS",
								text: "This post is already in PPS Status"
							});					
							m.open();					
						}
						else 
						{		
							b.post_manager('enable_pps',id);	
						}
				});
			});
		});
	});
}
function render_remove_button(id,board_id)
{
$(document).ready(function(){
	$.getScript('js/post.js', function(){
		var p = new Post();
		$(function() {
			$( "#" + id ).button({
		        icons: {
		            primary: "ui-icon-minus"
		        },
			 text: false
			});
			$( "#" + id ).click(function(){
				p.post_remove($(this).attr('id'));
			});
			
			$( "#" + board_id + "_" + id ).button({
	        icons: {
	            primary: "ui-icon-search"
	        },
			 text: false
			});
			$( "#" + board_id + "_" + id ).click(function(){
					window.open('scoutboard.php?boardid=' + board_id + "&title=" + $("#board_title").html(),null,'height=900,width=975,status=no,toolbar=no,menubar=no,location=no');
			});
			
		});
	});
});
};
