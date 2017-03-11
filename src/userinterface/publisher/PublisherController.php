<?php

// classpath
namespace Mimoto\UserInterface\publisher;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


/**
 * PublisherController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class PublisherController
{

    public function viewFeed(Application $app)
    {
        // 1. load data
        $eContentSection = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_CONTENTSECTION, 'value' => ['name' => 'Articles']]);

        // 2. create content
        $page = Mimoto::service('aimless')->createPage('feed', $eContentSection[0]);

        // 3. output
        return $page->render();
    }

    public function viewArticle(Application $app, $nArticleId)
    {
        // 2. load data
        $eArticle = Mimoto::service('data')->get('article', $nArticleId);

        // 3. create content
        $page = Mimoto::service('aimless')->createPage('article', $eArticle);

        // 5. output
        return $page->render();
    }

    public function addComment(Application $app, Request $request, $nArticleId)
    {
        // 1. init page
        $eComment = Mimoto::service('data')->create('comment');

        // 2. load and convert
        $requestData = json_decode($request->getContent());

        // 3. setup
        $eComment->setValue('message', $requestData->message);

        // 4. store
        Mimoto::service('data')->store($eComment);

        // 5. send
        return Mimoto::service('messages')->response('Comment added');
    }

}
