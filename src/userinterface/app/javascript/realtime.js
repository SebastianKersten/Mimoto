var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);

var quillDelta = require("quill-delta");


var Memcached = require('memcached');
var memcached = new Memcached('127.0.0.1:11211');

var aChatMessages = [];
var article = new quillDelta().insert('\n');


memcached.get('aChatMessages', function (err, data) {
    //console.log('aChatMessages in memory');
    //console.log(data);

    if (data) aChatMessages = data;
});


memcached.get('article', function (err, data) {

    console.log('article in memory:', data);

    if (data) article = new quillDelta(data);

});



app.get('/', function(req, res){
    res.sendFile(__dirname + '/realtime.html');
});

app.get('/collaborate', function(req, res){
    res.sendFile(__dirname + '/collaborate.html');
});

app.get('/mimoto.cms.js', function(req, res){
    res.sendFile(__dirname + '/temp/mimoto.cms.js');
});

io.on('connection', function(socket){

    console.log('a user connected');

    socket.broadcast.emit('chat message', 'hi');



    socket.emit('initialContent', article); //new quillDelta().insert('\n')); //article);


    socket.on('disconnect', function(){
        console.log('user disconnected');
    });

    socket.on('chat message', function(msg){

        console.log('message: ' + msg);

        aChatMessages.push(msg);

        memcached.set('aChatMessages', aChatMessages, 0, function (err) {
            console.log('aChatMessages has been updated');
        });

        io.emit('chat message', msg);
    });

    socket.on('ot', function(delta){

        // update
        article = article.compose(delta);


        console.log('article = ', article);


        socket.emit('ot-self', delta);
        socket.broadcast.emit('ot-other', delta);


        // store
        memcached.set('article', article, 0, function (err) {
            console.log('article has been updated');
        });


    });

    socket.on('selectionChange', function(range)
    {
        socket.broadcast.emit('selectionChange', range);
    });

});

http.listen(4000, function(){
    console.log('listening on *:4000');
});