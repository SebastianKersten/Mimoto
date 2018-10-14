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
    public function xxx(Application $app)
    {

        // __get Mimoto::user->get('selector')
        // __get Mimoto::data->
        // __get Mimoto::config->

        // __get Mimoto::service('')-> (some basic core services, some extended. Everything overrideable) use interface?
//
//
//        Mimoto::output('email', Mimoto::user()->get('email'));
//
//        if (!empty(Mimoto::user()->get('biography')))
//        {
//            Mimoto::error(Mimoto::user()->get('biography'));
//        }
//        else
//        {
//            Mimoto::error('NOT a owner');
//        }



//        $eUser = Mimoto::service('data')->get(CoreConfig::MIMOTO_USER, 1);
//        Mimoto::error($eUser);


        $eMember = Mimoto::service('data')->get('member', 1);
        Mimoto::error($eMember->get('email'));
    }



    public function viewPeople(Application $app)
    {
        // 1. init
        $page = Mimoto::service('output')->create('People');

        // 2. fill
        $page->fillContainer('people', Mimoto::service('data')->select('people'), 'Author');

        // 3. output
        return $page->render();
    }

    public function addComment(Application $app, Request $request, $nArticleId)
    {
        // ---> replace with inline form


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
        // ---> replace with api (check ownershow or group permissionuseAsUserExtension


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
