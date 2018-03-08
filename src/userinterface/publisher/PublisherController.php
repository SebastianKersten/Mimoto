<?php

// classpath
namespace Mimoto\UserInterface\publisher;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;
use Mimoto\Data\MimotoDataUtils;

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
        $eContentSection = Mimoto::service('data')->select(['type' => CoreConfig::MIMOTO_DATASET, 'values' => ['name' => 'Articles']]);

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


    public function showPages(Application $app, $nPageId)
    {
        // 1. load data
        $ePage = Mimoto::service('data')->get('page', $nPageId);

        // 2. create template
        $page = Mimoto::service('output')->createPage('page', $ePage);

        // 3. output
        return $page->render();
    }

}
