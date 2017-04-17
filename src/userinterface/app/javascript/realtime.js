var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

var quillDelta = require("quill-delta");


var aClients = [];

var Memcached = require('memcached');
var memcached = new Memcached('127.0.0.1:11211');

// var aChatMessages = [];
var article = new quillDelta().insert('\n');


// memcached.get('aChatMessages', function (err, data) {
//     //console.log('aChatMessages in memory');
//     //console.log(data);
//
//     if (data) aChatMessages = data;
// });


memcached.get('article', function (err, data) {

    console.log('article in memory:', data);

    if (data) article = new quillDelta(data);

});


app.get('/collaborate', function(req, res){
    res.sendFile(__dirname + '/collaborate.html');
});

app.get('/mimoto.cms.js', function(req, res){
    res.sendFile(__dirname + '/temp/mimoto.cms.js');
});



// socket.on("connection", function (client)
// {
//     client.on("join", function(name)
//     {
//         aClients[client.id] = name;
//
//         client.emit("update", "You have connected to the server.");
//
//         socket.sockets.emit("update", name + " has joined the server.");
//         socket.sockets.emit("update-people", people);
//     });
//
//     client.on("send", function(msg)
//     {
//         socket.sockets.emit("chat", people[client.id], msg);
//     });
//
//     client.on("disconnect", function()
//     {
//         socket.sockets.emit("update", aClients[client.id] + " has left the server.");
//         delete aClients[client.id];
//         socket.sockets.emit("update-people", people);
//     });
// });



io.on('connection', function(client) {

    console.log('a user connected');


    client.on("logon", function (data)
    {
        console.log('Logon', data);
    });


    client.on('disconnect', function()
    {
        console.log('user disconnected');
    });

    client.on('connectToValue', function(sPropertySelector)
    {
        // jonty
        client.join(sPropertySelector);


        memcached.get(this._sPropertySelector, function (err, data)
        {

            if (!data)
            {
                // 1. get from php
            }



            console.log('article in memory:', data);

            if (data) article = new quillDelta(data);

        });


        //
        client.emit('mostCurrentDraft', value);
    });

    client.on('ot', function(delta){

        // update
        article = article.compose(delta);


        console.log('article = ', article);


        client.emit('ot-self', delta);
        client.broadcast.emit('ot-other', delta);


        // store
        memcached.set('article', article, 0, function (err) {
            console.log('article has been updated');
        });


    });

    client.on('selectionChange', function(range)
    {
        client.broadcast.emit('selectionChange', range);
    });

});

http.listen(4000, function(){
    console.log('listening on *:4000');
});