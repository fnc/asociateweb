// JavaScript Document

function muestraPrecio() { 
		var first = document.getElementById("textbox1").value;
		var resultadoNumerico = parseFloat(first) * precioAccion || 0
		var answer = "$" + resultadoNumerico;
		var textbox2 = document.getElementById('textbox2');
		textbox2.value=answer;
}

