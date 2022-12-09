$(function(){
	
    $(document).bind("contextmenu",function(e){
        return false;
    });
	
});


$(document).ready(function(){

 
	$("#NavMod").load('../view/View-moduloPanel.php');
 
	$("body").backgroundCycle({
                    imageUrls: [
                        '../../kimages/erpK.jpg',
                        '../../kimages/erpKM.jpg',
                        '../../kimages/erpKS.jpg',
						'../../kimages/erpKG.jpg',
                    ],
                    fadeSpeed: 2000,
                    duration: 5000,
                    backgroundSize: SCALING_MODE_COVER
     });
	
});

 