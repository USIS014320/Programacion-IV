console.log("Hola Mundo desde Nodejs");

var num1 = 5,
    num2 = 8.5,
    num3 = 7,
    resp = num1 + num2;
    resp1 = resp * num3;

console.log("La Respuesta Es", resp1);


var ntable = 5;
for(var i=1; i<=10; i++){
    console.log(ntable + " x " + i + " = " + ntable * i);
}

//SEVER NODEJS ************************************************************************************************************************
var http = require('http').createServer(function(req, resp){
    resp.writeHead(200, {'Content-Type': 'text/html'});
    resp.write("<h1>Hola AngezKa </h1>"
    + "<h3>Hola Mundo desde Nodejs</h3>");
});
http.listen(3001, function(){
    console.log("Servidor Corriendo en el puerto 3001");
});
