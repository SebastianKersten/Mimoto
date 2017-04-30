function addComment(nArticleId)
{
    // register
    var commentForm = document.getElementById('commentForm');
    
    // call
    MimotoX.utils.callAPI({
        type: 'post',
        url: "/publisher/article/" + nArticleId + "/comment/add",
        data: {message: commentForm.value},
        dataType: 'json',
        success: function(resultData, resultStatus, resultSomething) {
            commentForm.value = '';
            window.scrollTo(0,document.body.scrollHeight);
        }
    });
}

function removeComment(nCommentId)
{
    // call
    MimotoX.utils.callAPI({
        type: 'post',
        url: "/publisher/comment/" + nCommentId + "/remove",
        data: {message: commentForm.value},
        dataType: 'json',
        success: function(resultData, resultStatus, resultSomething) {
        }
    });
}

function highlightComment(nCommentId)
{
    // call
    MimotoX.utils.callAPI({
        type: 'post',
        url: "/publisher/comment/" + nCommentId + "/highlight",
        data: null,
        dataType: 'json',
        success: function(resultData, resultStatus, resultSomething) {
        }
    });
}

function unhighlightComment(nCommentId)
{
    // call
    MimotoX.utils.callAPI({
        type: 'post',
        url: "/publisher/comment/" + nCommentId + "/unhighlight",
        data: null,
        dataType: 'json',
        success: function(resultData, resultStatus, resultSomething) {
        }
    });
}

function setupEditabeField()
{
    // register
    var editor = document.getElementById('editor');
    
    // setup
    editor.contentEditable = true;
    
    // listen to changes
    //editor.onchange(function(){ console.log(editor.innerHTML); });
    //$("body").on('DOMSubtreeModified', "mydiv", function() { });
    
    // https://www.w3schools.com/jsref/met_document_createdocumentfragment.asp
    // https://developer.mozilla.org/en/docs/Web/HTML/Element/figure
    // https://gist.github.com/kentliau/2fbc9124a50c254cad9e
    
    // var contents = document.querySelectorAll("[contenteditable=true]");
    // [].forEach.call(contents, function (content) {
    //     // When you click on item, record into `data-initial-text` content of this item.
    //     content.addEventListener("focus", function () {
    //         content.setAttribute("data-initial-text", content.innerHTML);
    //     });
    //     // When you leave an item...
    //     content.addEventListener("blur", function () {
    //         // ...if content is different...
    //         if (content.getAttribute("data-initial-text") !== content.innerHTML) {
    //             // ... do something.
    //             console.log("New data when content change.");
    //             console.log(content.innerHTML);
    //         }
    //     });
    // });
    
}
