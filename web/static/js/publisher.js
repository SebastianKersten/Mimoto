function addComment(nArticleId)
{
    // register
    var commentForm = document.getElementById('commentForm');
    
    // call
    Mimoto.Aimless.utils.callAPI({
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
    Mimoto.Aimless.utils.callAPI({
        type: 'post',
        url: "/publisher/comment/" + nCommentId + "/remove",
        data: {message: commentForm.value},
        dataType: 'json',
        success: function(resultData, resultStatus, resultSomething) {
        }
    });
}
