const express = require('express'),
    server = express(),
    mongodb = require('mongodb').MongoClient,
    url = 'mongodb://localhost:27017',
    port = 3001,
    http = require('http').Server(server)
    io = require('socket.io')(http, {
        allowEI03:true,
        cors:{
            origin:['http://localhost:8000'],
            credentials:true
        }
    });
server.use(express.json());

io.on('connect', function (socket) {
    console.log('Conectado via socket');

    socket.on('historial', function (e) {
        mongodb.connect(url, function (err, client) {
            if (err) console.log(err);
            const db = client.db('chatDB');
            db.collection('chat').find().toArray(function (err, chats) {
                if (err) console.log(err);
                socket.emit('historial', chats); //enviamos los datos a quien los solicito
            });
        });
    });
    socket.on('chat', function (chat) {
        mongodb.connect(url, function (err, client) {
            if (err) console.log(err);
            const db = client.db('chatDB');
            db.collection('chat').insertOne(chat).then(err, result => {
                io.emit('chat', chat); //enviar a todos el mensaje recibido
            }).catch(err => {
                console.log(err);
            });
        });
    });
});

server.get('/chat', function(req, resp){
    resp.send('Hola Mundo');
});

server.get('/usuarios/list', function(req, resp){
    mongodb.connect(url, function(err, client){
        if(err) resp.send(err);
        const db = client.db('prueba');
        db.collection('usuarios').find({}).toArray(function(err,data){
            if(err) resp.send(err);
            resp.send(data);
        });
    });
});
server.get('/usuarios/nuevo', function(req, resp){
    resp.sendFile(__dirname + '/index.html');
});
server.post('/usuarios/save', function(req, resp){
    mongodb.connect(url, function(err, client){
        if(err) resp.send(err);
        const db = client.db('prueba');
        db.collection('usuarios').insertOne(req.body,function(err, result){
            if(err) resp.send(err);
            resp.send(result);
        });
    });
});

/*server.listen(port, function(event){
    console.log('Server running on port 3001');
});*/
http.listen(port, function(e){
    console.log(`Server corriendo en puerto ${port}`);
});