$(function(){
	$(".input-datepicker").datepicker({
		dateFormat:"dd/mm/yy",
		changeMonth:true,
		changeYear:true,
		showButtonPanel:false,
		beforeShow:function(textbox, instance){
			var $self = $(this);
			var $fieldset = $self.parents("fieldset");
			if($fieldset.find(".dpContainer").length==0){
				var $tmpDiv = $("<div/>",{
					class:"dpContainer"
				})
				$fieldset.append($tmpDiv);
			}else{
				$tmpDiv = $fieldset.find(".dpContainer");
			}
			$tmpDiv.css({
				position:"absolute",
				left:-$self.offset().left+$self.position().left,
				top:-$self.offset().top+$self.position().top
			})
			$tmpDiv.append($(instance.dpDiv[0]));
			$("#ui-datepicker-div").hide();
		}
	});
	$(".input-datepicker").bind("click",function(){
		$(this).datepicker("show");
	});
	// $(".input-datepicker").on("changeDate",function(){
	// 	$(this).datepicker("hide");
	// })
	$(".input-datepicker").bind("keyup change",function(){
		$(this).datepicker("hide");
	});
})