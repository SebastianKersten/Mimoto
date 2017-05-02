var app = require('express')();
var http = require('http').Server(app);
var socketIO = require('socket.io')(http);


var httpMimoto = require('http').Server(app);
var socketIOMimoto = require('socket.io')(httpMimoto);

var runner = require("child_process");

var QuillDelta = require("quill-delta");


var aClients = [];
var aRooms = [];

// var Memcached = require('memcached');
// var memcached = new Memcached('127.0.0.1:11211');


// app.get('/reset', function(req, res){
//
//     var deltaValue = new QuillDelta().insert('Lorem ipsum\n');
//
//     // store
//     memcached.set('draft:article.1.body', deltaValue, 0, function (err) {
//         console.log('------------- Draft has been reset');
//     });
//
//     // store
//     memcached.set('draft:article.1.body:count', 0, 0, function (err) {
//         console.log('------------- Draft count has been reset');
//     });
//
//     res.send('The draft of `article.1.body` has been reset!');
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

        // 3. update clients with user lists


        // 1. join room
        client.join(sPropertySelector);

        // 2. send welcome message
        client.emit('message', 'You have entered room `' + sPropertySelector + '`');

        // 3. let the others know a new person entered thr room
        client.broadcast.to(sPropertySelector).emit('message', client.user.name + ' has entered room `' + sPropertySelector + '`');



        // 4. get all clients
        var aClientsInRoom = socketIO.sockets.adapter.rooms[sPropertySelector].sockets;

        //to get the number of clients
        //var numClients = (typeof aClientsInRoom !== 'undefined') ? Object.keys(aClientsInRoom).length : 0;

        // 5. let the others now about the new client
        for (var clientId in aClientsInRoom)
        {
            // skip current client
            if (clientId == client.id) continue;

            // this is the socket of each client in the room.
            var clientSocket = socketIO.sockets.connected[clientId];

            // report the new client know about the others in this room
            client.emit('message', clientSocket.user.name + ' is also in room `' + sPropertySelector + '`');
        }


        // verify
        if (!aRooms[sPropertySelector])
        {
            // load
            runner.exec
            (
                "curl http://mimoto.aimless/mimoto.cms/recent/" + sPropertySelector,
                function (error, stdout, stderr)
                {
                    // init
                    var dBaseDocument = new QuillDelta().insert(stdout);

                    // setup and store in memory
                    aRooms[sPropertySelector] = {
                        sPropertySelector: sPropertySelector,
                        content: dBaseDocument,
                        nDeltaIndex: 0,
                        aDeltas: []
                    };

                    // send
                    _broadcastBaseDocument(client, sPropertySelector);
                }
            );
        }
        else
        {
            // send
            _broadcastBaseDocument(client, sPropertySelector);
        }
    });

    client.on('ot', function(change)
    {
        // validate
        if (!change || !change.delta) return;


        // convert
        var delta = new QuillDelta(change.delta);





        // register
        var sPropertySelector = change.sPropertySelector;


        // register
        var baseDocument = aRooms[sPropertySelector];






        console.log('=== Start === ');
        console.log(JSON.stringify(baseDocument.aDeltas, null, 2));
        console.log('=== End ===');


        console.log('deltaIndex of client = ' + change.nCurrentlyKnownDeltaIndex);
        console.log('current deltaIndex = ' + (baseDocument.nDeltaIndex - 1));


        if (change.nCurrentlyKnownDeltaIndex < baseDocument.nDeltaIndex - 1)
        {

            console.log('Client is not in sync with server ...');
            console.log('Starting correction ...');

            // #question is this part still relevant?


            console.log(JSON.stringify(baseDocument.aDeltas, null, 2));


            for (var nIndex = change.nCurrentlyKnownDeltaIndex + 1; nIndex <= baseDocument.nDeltaIndex - 1; nIndex++)
            {


                // register
                var deltaFromHistory = baseDocument.aDeltas[nIndex];

                console.log('deltaFromHistory', deltaFromHistory);

                console.log('> delta before', delta);
                delta = new QuillDelta(deltaFromHistory.transform(delta, false));
                console.log('> delta after', delta);
            }

            //change.delta

            console.log('Correction finished...', JSON.stringify(delta, null, 2));
        }
        else
        {
            console.log('Client and server in sync.');
        }



        // store
        aRooms[sPropertySelector].aDeltas[baseDocument.nDeltaIndex] = delta;



        // 1. transform vanaf meegestuurd id
        // 2. erna: pas toe op document



        //console.log(JSON.stringify(aRooms[sPropertySelector].aDeltas[nNewDeltaIndex], null, 2));


        // update data
        baseDocument.content = baseDocument.content.compose(delta);



        //console.log('baseDocument on server', JSON.stringify(baseDocument.content, null, 2));



        var parsedDelta = {
            user: client.user,
            sPropertySelector: change.sPropertySelector,
            delta: delta,
            nNewDeltaIndex: baseDocument.nDeltaIndex
        };

        // update
        baseDocument.nDeltaIndex++;


        // send
        client.emit('ot-self', parsedDelta);
        client.broadcast.to(sPropertySelector).emit('ot-other', parsedDelta);
    });

    client.on('selectionChange', function(range)
    {
        client.broadcast.emit('selectionChange', range);
    });

});

http.listen(4000, function(){
    console.log('listening on *:4000');
});



_broadcastBaseDocument = function(client, sPropertySelector)
{
    // prepare
    var baseDocument = {
        sPropertySelector: sPropertySelector,
        content: aRooms[sPropertySelector].content,
        nDeltaIndex: aRooms[sPropertySelector].nDeltaIndex
    };

    // send
    client.emit('baseDocument', baseDocument);
}





/// --- Mimoto


socketIOMimoto.on('connection', function(server)
{

    console.log('Mimoto is connected');

    server.on('disconnect', function () {
        console.log('Mimoto is disconnected');
    });


    server.on("logon", function (data)
    {
        //console.log('Logon', JSON.stringify(data, null, 2));

        //console.log(aClients);

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


    server.on("data.changed", function(data)
    {
        console.log('data.changed');
        socketIO.emit('data.changed', data);
    });

    server.on("data.created", function(data)
    {
        console.log('data.created');
        socketIO.emit('data.created', data);
    });

});

httpMimoto.listen(4001, function(){
    console.log('listening to Mimoto on *:4001');
});