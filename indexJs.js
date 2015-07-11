$(document).ready(function(){
    $("#decryptButton").click(function(){
		var writtenText = document.getElementById('encText').value;
		var writtenKey = document.getElementById('encKey').value;
		$(".result").remove();
		$(".showRot").remove();
		$(".removeSpace").remove();
		$("#content").unbind();
		
		$.ajax({  
			type: "POST",  
			url: "keyCalc.php",
			data: { encryptedText: writtenText, key: writtenKey}, 
			dataType: "json",
			cache: false,
		}).done(function(data) {
				var keyedItems;
				if(writtenKey){
					keyedItems = $(getResult("AES128: ", data.aes128)+getResult("AES192: ", data.aes192)+
									getResult("AES256: ", data.aes256)+getResult("3DES: ", data.tripDES)+
									getResult("Blowfish: ", data.blowfish)+getResult("Twofish: ", data.twofish)+
									getResult("Serpent: ", data.serpent)+getResult("Cast128: ", data.cast128)+
									getResult("Cast256: ", data.cast256)).hide();
				}
				var items = $(getResult("Binary: ",  data.binary)+
									getResult("Hexa: ", data.hex)+getResult("Atbash: ", data.atbash)+
									getResult("Rot13: ", data.rot13)+
									'<button class="showRot">Show other rots</button><br class="removeSpace">'+
									getRotResult("Rot1: ", data.rot1)+getRotResult("Rot2: ", data.rot2)+
									getRotResult("Rot3: ", data.rot3)+getRotResult("Rot4: ", data.rot4)+
									getRotResult("Rot5: ", data.rot5)+getRotResult("Rot6: ", data.rot6)+
									getRotResult("Rot7: ", data.rot7)+getRotResult("Rot8: ", data.rot8)+
									getRotResult("Rot9: ", data.rot9)+getRotResult("Rot10: ", data.rot10)+
									getRotResult("Rot11: ", data.rot11)+getRotResult("Rot12: ", data.rot12)+
									getRotResult("Rot13: ", data.rot13)+getRotResult("Rot14: ", data.rot14)+
									getRotResult("Rot15: ", data.rot15)+getRotResult("Rot16: ", data.rot16)+
									getRotResult("Rot17: ", data.rot17)+getRotResult("Rot18: ", data.rot18)+
									getRotResult("Rot19: ", data.rot19)+getRotResult("Rot20: ", data.rot20)+
									getRotResult("Rot21: ", data.rot21)+getRotResult("Rot22: ", data.rot22)+
									getRotResult("Rot23: ", data.rot23)+getRotResult("Rot24: ", data.rot24)+
									getRotResult("Rot25: ", data.rot25)).hide();
				if(writtenKey) $("#content").append(keyedItems);
				$("#content").append(items);
				items.slideToggle();
				if(writtenKey) keyedItems.slideToggle();
				$(".rotResult").hide();
				$("#content").on("click", "button.showRot", function(){
					$(".rotResult").slideToggle();
				});
			}); 
		
    });
});

function getResult(title, data){
	return '<div class="result"><p><b>'+title+'</b></p><textarea readonly class="resultText">'+data.replace(/\0/g, '')+'</textarea></div><br class="removeSpace">';
}

function getRotResult(title, data){
	return '<div class="rotResult result"><p><b>'+title+'</b></p><textarea readonly class="resultText">'+data+'</textarea></div><br class="removeSpace">';
}