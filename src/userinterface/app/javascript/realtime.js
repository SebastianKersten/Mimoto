var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);


var httpMimoto = require('http').Server(app);
var ioMimoto = require('socket.io')(httpMimoto);

var runner = require("child_process");

var quillDelta = require("quill-delta");


var aClients = [];

var Memcached = require('memcached');
var memcached = new Memcached('127.0.0.1:11211');

// var aChatMessages = [];
//var article = new quillDelta().insert('\n');


// memcached.get('aChatMessages', function (err, data) {
//     //console.log('aChatMessages in memory');
//     //console.log(data);
//
//     if (data) aChatMessages = data;
// });


// memcached.get('article', function (err, data) {
//
//     console.log('article in memory:', data);
//
//     if (data) article = new quillDelta(data);
//
// });


app.get('/collaborate', function(req, res){
    res.sendFile(__dirname + '/collaborate.html');

    //runner.exec("curl http://mimoto.aimless/mimoto.cms/logon", function (error, stdout, stderr) { console.log('done', stdout); res.send(stdout); } );

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



io.on('connection', function(socket) {

    console.log('a user connected');


    var client = {
        socket: socket
    }


    aClients.push(client);


    console.log('Connected clients after connect', aClients);



    client.socket.on('disconnect', function()
    {
        console.log('user disconnected');

        var nClientCount = aClients.length;
        for (var nClientIndex = 0; nClientIndex < nClientCount; nClientIndex++)
        {
            // validate
            if (aClients[nClientIndex].socket == socket)
            {
                aClients.splice(nClientIndex, 1);
                break;
            }
        }


        console.log('Connected clients after disconnect', aClients);


    });


    client.socket.on('edit', function(sPropertySelector)
    {
        // jonty
        //client.socket.join(sPropertySelector);




        memcached.get('draft:' + sPropertySelector, function (err, delta)
        {

            if (!delta)
            {

                console.log('No data in memcache ...');
                console.log('Loading from MySQL ...');

                runner.exec(
                    "curl http://mimoto.aimless/mimoto.cms/recent/" + sPropertySelector,
                    function (error, stdout, stderr)
                    {
                        // build
                        var deltaValue = new quillDelta().insert(stdout);

                        // store
                        memcached.set('draft:' + sPropertySelector, deltaValue, 0, function (err) {
                            console.log('------------- Draft has been loaded and set');
                        });
                    }
                );
            }


            console.log('Draft of `' + sPropertySelector + '` in memory:', delta);

            client.socket.emit('mostRecentDraft', delta);

        });


        //

    });

    client.socket.on('ot', function(change)
    {
        console.log('OT change = ', change);

        // 1. memcache could be cleared from external. add check (and refresh editors)

        memcached.get('draft:' + change.sPropertySelector, function (err, deltaValue)
        {
            var delta = new quillDelta(deltaValue);

            // update data
            delta = delta.compose(change.delta);

            // store
            memcached.set('draft:' + change.sPropertySelector, delta, 0, function (err) {
                console.log('data has been updated');
            });

            memcached.get('draft:' + change.sPropertySelector, function (err, deltaValue)
            {
                console.log('updated data = ', deltaValue);
            });
        });

        client.socket.emit('ot-self', change.delta);
        client.socket.broadcast.emit('ot-other', change.delta);

    });

    client.socket.on('selectionChange', function(range)
    {
        client.socket.broadcast.emit('selectionChange', range);
    });

});

http.listen(4000, function(){
    console.log('listening on *:4000');
});


/// --- Mimoto


ioMimoto.on('connection', function(server)
{

    console.log('Mimoto is connected');

    server.on('disconnect', function () {
        console.log('Mimoto is disconnected');
    });


    server.on("logon", function (data)
    {
        console.log('Mimoto logon user', data);

        var nClientCount = aClients.length;
        for (var nClientIndex = 0; nClientIndex < nClientCount; nClientIndex++)
        {
            // validate
            if (aClients[nClientIndex].socket.id == data.socketId)
            {
                aClients[nClientIndex].user = data;
                aClients[nClientIndex].socket.emit('logon', 'SUCCESS!');
                break;
            }
        }

    });

    server.on("logoff", function (data)
    {
        console.log('Mimoto logoff', data); // for instance in case of forced logout
    });

});

httpMimoto.listen(4001, function(){
    console.log('listening to Mimoto on *:4001');
});