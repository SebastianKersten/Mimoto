var app = require('express')();
var http = require('http').Server(app);
var socketIO = require('socket.io')(http);


var httpMimoto = require('http').Server(app);
var socketIOMimoto = require('socket.io')(httpMimoto);

var runner = require("child_process");

var QuillDelta = require("quill-delta");


var aClients = [];
var aRooms = [];

var Memcached = require('memcached');
var memcached = new Memcached('127.0.0.1:11211');


app.get('/reset', function(req, res){

    var deltaValue = new QuillDelta().insert('Lorem ipsum\n');

    // store
    memcached.set('draft:article.1.body', deltaValue, 0, function (err) {
        console.log('------------- Draft has been reset');
    });

    // store
    memcached.set('draft:article.1.body:count', 0, 0, function (err) {
        console.log('------------- Draft count has been reset');
    });

    res.send('The draft of `article.1.body` has been reset!');
});


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



socketIO.on('connection', function(client)
{
    // register
    aClients[client.id] = client;


    client.on('disconnect', function()
    {
        // cleanup
        delete aClients[client.id];
    });


    client.on('edit', function(sPropertySelector)
    {

        // 1. join article-room - client.socket.join(sPropertySelector);
        // 2. send list of users in this room
        // 3. update clients with user lists


        client.join(sPropertySelector);


        aRooms[sPropertySelector] = {
        };


        socketIO.sockets.in(sPropertySelector).emit('message', client.user.name + ' has entered room `' + sPropertySelector + '`');



        var aClientsInRoom = socketIO.sockets.adapter.rooms[sPropertySelector].sockets;

        //to get the number of clients
        //var numClients = (typeof aClientsInRoom !== 'undefined') ? Object.keys(aClientsInRoom).length : 0;

        for (var clientId in aClientsInRoom){

            if (clientId == client.id) continue;


            //this is the socket of each client in the room.
            var clientSocket = socketIO.sockets.connected[clientId];

            //you can do whatever you need with this
            clientSocket.emit('new event', "Updates");
            client.emit('message', clientSocket.user.name + ' is also in room `' + sPropertySelector + '`');

        }

        //var aClientsInRoom = socketIO.sockets.clients(sPropertySelector);

        // aClientsInRoom.forEach(function(clientInRoom)
        // {
        //     // if (clientInRoom != client)
        //     // {
        //     //     socketIO.sockets.in(sPropertySelector).emit('message', clientInRoom.user.name + ' is also in room `' + sPropertySelector + '`');
        //     // }
        // });



        memcached.get('draft:' + sPropertySelector, function (err, deltaDocument)
        {

            if (!deltaDocument)
            {

                // console.log('No data in memcache ...');
                // console.log('Loading from MySQL ...');

                runner.exec(
                    "curl http://mimoto.aimless/mimoto.cms/recent/" + sPropertySelector,
                    function (error, stdout, stderr)
                    {
                        // build
                        var deltaValue = new QuillDelta().insert(deltaDocument);

                        // store
                        memcached.set('draft:' + sPropertySelector, deltaValue, 0, function (err) {
                            console.log('------------- Draft has been loaded and set');
                        });
                    }
                );
            }

            //console.log('Draft of `' + sPropertySelector + '` in memory:',  JSON.stringify(deltaDocument, null, 2));

            client.emit('mostRecentDraft', deltaDocument);

        });
    });

    client.on('ot', function(change)
    {
        // validate
        if (!change || !change.delta) return;




        // 1. transform op history
        // 2. remove all older than most recent client otid

        var sender = aClients[client.id];




        console.log('---> otid for ' + sender.user.name + ' = ' + change.otid);
        console.log('---> change = ', JSON.stringify(change, null, 2));


        var nCurrentCount = null;

        memcached.get('draft:' + change.sPropertySelector + ':count', function (err, nDraftCount)
        {
            nCurrentCount = nDraftCount + 1;

            memcached.set('draft:article.1.body:count', nCurrentCount, 0, function (err) {
                console.log('New draftCount = ' + nCurrentCount);
            });
        });



        // 1. memcache could be cleared from external. add check (and refresh editors)

        memcached.get('draft:' + change.sPropertySelector, function (err, storedDocument)
        {
            var delta = new QuillDelta(storedDocument);

            // update data
            delta = delta.compose(change.delta);

            // store
            memcached.set('draft:' + change.sPropertySelector, delta, 0, function (err) {
                console.log('data has been updated');
            });

            var parsedChange = {
                user: client.user,
                delta: change.delta,
                otid: nCurrentCount
            };


            client.emit('ot-self', parsedChange);
            client.broadcast.emit('ot-other', parsedChange);
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


/// --- Mimoto


socketIOMimoto.on('connection', function(server)
{

    console.log('Mimoto is connected');

    server.on('disconnect', function () {
        console.log('Mimoto is disconnected');
    });


    server.on("logon", function (data)
    {
        console.log('Logon', JSON.stringify(data, null, 2));


        console.log(aClients);

        aClients[data.socketId].user = data.user;
        aClients[data.socketId].emit('logon', data);

        //
        // var nClientCount = aClients.length;
        // for (var nClientIndex = 0; nClientIndex < nClientCount; nClientIndex++)
        // {
        //     // validate
        //     if (aClients[nClientIndex].socket.id == data.socketId)
        //     {
        //         aClients[nClientIndex].user = data;
        //         aClients[nClientIndex].
        //
        //
        //         //console.log('Mimoto logon user', aClients[nClientIndex].user);
        //
        //         break;
        //     }
        // }

    });

    server.on("logoff", function (data)
    {
        console.log('Mimoto logoff', data); // for instance in case of forced logout
    });

});

httpMimoto.listen(4001, function(){
    console.log('listening to Mimoto on *:4001');
});