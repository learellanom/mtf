	//
	//
	// 	script con inputmask para mascaras de entrada 
	//		Montos		clase		amountMask
	//		tasas		clase		rateMask
	//	Requisitos
	//		Jquery
	//		Jquery.inputmask
	//		este script
	//
	$(document).ready(function(){
	
		// Montos
       $(".amountMask").attr("minlength","22");
	   $(".amountMask").attr("maxlength","22"); 
	   $(".amountMask").inputmask({
			alias: 'decimal',
			allowMinus: false,  			
			autoUnmask:true,
			removeMaskOnSubmit:true,
			rightAlign: true,
			groupSeparator:".",
			undoOnEscape:true,
			insertMode:false,
			clearIncomplete:true,
			digits: 2,		
			insertMode:true,

		}); 

		// Taza
       $(".rateMask").attr("minlength","5"); 
	   $(".rateMask").attr("maxlength","5"); 
	   $(".rateMask").inputmask({
			alias: 'decimal',
			// mask: "{4,4}",
			repeat: 4,
			allowMinus: false,  			
			autoUnmask:true,
			removeMaskOnSubmit:true,
			rightAlign: true,
			groupSeparator:".",
			undoOnEscape:true,
			insertMode: false,
			clearIncomplete:true,
			digits: 2,		
			insertMode:true,

		});
		

	
	});
	
	