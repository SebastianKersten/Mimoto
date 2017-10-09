<?php

// classpath
namespace Mimoto\UserInterface\publisher;

// Mimoto classes
use Mimoto\Data\MimotoDataUtils;
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


/**
 * PublisherController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class PublisherController
{
    public function viewPeople(Application $app)
    {
        // 1. init
        $page = Mimoto::service('output')->create('People');

        // 2. fill
        $page->fillContainer('people', Mimoto::service('data')->select('people'), 'Author');

        // 3. output
        return $page->render();
    }

    public function viewFeed(Application $app)
    {
        // 1. load data
        $eContentSection = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_DATASET, 'value' => ['name' => 'Articles']]);

        // 2. create template
        $page = Mimoto::service('output')->createPage('Feed', (!empty($eContentSection)) ? $eContentSection[0] : '');

        // 3. output
        return $page->render();
    }

    public function viewArticle(Application $app, $nArticleId)
    {
        // 1. load data
        $eArticle = Mimoto::service('data')->get('article', $nArticleId);

        // 2. create template
        $page = Mimoto::service('output')->createPage('Article', $eArticle);

        // 3. output
        return $page->render();
    }

    public function addComment(Application $app, Request $request, $nArticleId)
    {
        // 1. load and convert
        $data = MimotoDataUtils::decodePostData($request->get('data'));

        // 1. init page
        $eComment = Mimoto::service('data')->create('comment');

        // 2. register
        $eComment->setValue('message', $data->message);

        // 3. store
        Mimoto::service('data')->store($eComment);

        // 4. load article
        $eArticle = Mimoto::service('data')->get('article', $nArticleId);

        // 5. register
        $eArticle->addValue('comments', $eComment);

        // 6. store
        Mimoto::service('data')->store($eArticle);

        // 7. send
        return Mimoto::service('messages')->response('Comment added');
    }

    public function removeComment(Application $app, $nCommentId)
    {
        // 1. load comment
        $eComment = Mimoto::service('data')->get('comment', $nCommentId);

        // 2. delete comment
        Mimoto::service('data')->delete($eComment);

        // 3. send
        return Mimoto::service('messages')->response('Comment removed');
    }

    public function viewEditor(Application $app, $nArticleId)
    {
        // 1. load data
        $eArticle = Mimoto::service('data')->get('editor', $nArticleId);

        // 2. create template
        $page = Mimoto::service('output')->createPage('editor', $eArticle);

        // 3. output
        return $page->render();
    }



    public function viewInbox(Application $app)
    {

        $instagram = new \Instagram\Instagram();

        try {
            //Login
            $instagram->login(Mimoto::value('config')->instagram->username, Mimoto::value('config')->instagram->password);



            //Find User by Username
            $user = $instagram->getUserByUsername("the.vulva.gallery");
            //Get Feed of User by Id
            $userFeed = $instagram->getUserFeed($user);
            //Iterate over Items in Feed
            foreach($userFeed->getItems() as $feedItem){
                //User Object, (who posted this)
                $user = $feedItem->getUser();
                //Caption Object
                $caption = $feedItem->getCaption();
                //How many Likes?
                $likeCount = $feedItem->getLikeCount();
                //How many Comments?
                $commentCount = $feedItem->getCommentCount();
                //Get the Comments
                $comments = $feedItem->getComments();
                //Which Filter did they use?
                $filterType = $feedItem->getFilterType();
                //Grab a list of Images for this Post (different sizes)
                $images = $feedItem->getImageVersions2()->getCandidates();
                //Grab the URL of the first Photo in the list of Images for this Post
                $photoUrl = $images[0]->getUrl();
                //todo: Do something with it :)
                //Output the Photo URL
                //echo $photoUrl . "\n";


                echo '<div style="display:inline-block">';
                echo '<div><img src="'.$photoUrl.'" width="400" /></div>';
                echo '<div style="font-style:italic;color:#858585;">'.$caption->getText().'</div>';
                echo '<div style="display:inline-block;background-color:#ff0000;color:#ffffff;">'.$likeCount.' likes</div>';
                echo '<div style="display:inline-block;background-color:#000000;color:#ffffff;">'.$commentCount.' comments</div>';
                echo '</div>';


                //Mimoto::error($feedItem->getId());

                $aAllComments = [];
                $nCommentsLoaded = 0;
                $sMaxId = '';
                while ($nCommentsLoaded < $commentCount)
                {
                    $mediaComments = $instagram->getMediaComments($feedItem, $sMaxId);


                    $aNewBatch = [];

                    foreach ($mediaComments->getComments() as $mediaComment)
                    {
                        $nCommentsLoaded++;

                        $aNewBatch[] = (object) array(
                            'username' => $mediaComment->getUser()->getUsername(),
                            'comment' => $mediaComment->getText(),
                            'isHidden' => $mediaComment->getType() == 2
                        );

                        Mimoto::output('$mediaComment', $mediaComment);
                    }




                    $aAllComments = array_merge($aNewBatch, $aAllComments);

                    // prepare
                    $sMaxId = $mediaComments->getNextMaxId();
                }


                $nCommentCount = count($aAllComments);
                for ($nCommentIndex = 0; $nCommentIndex < $nCommentCount; $nCommentIndex++)
                {
                    // register
                    $comment = $aAllComments[$nCommentIndex];

                    // output
                    if ($comment->isHidden) echo '<strike style="font-style:italic;color:#858585;">';

                    echo '<b>'.($nCommentIndex + 1).' - '.$comment->username.'</b> - '.$comment->comment.'<br>';

                    if ($comment->isHidden) echo '</strike>';
                }

            }

        } catch(Exception $e){
            //Something went wrong...
            echo $e->getMessage() . "\n";
        }


        return '';
    }

}
