<?php

// classpath
namespace Mimoto\UserInterface\thetimeline;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


/**
 * TimelineController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class TimelineController
{

    public function viewTimeline(Application $app, $nTimelineId)
    {
        // 1. load data
        $eTimeline = Mimoto::service('data')->get('timeline', $nTimelineId);

        // 2. create template
        $page = Mimoto::service('output')->createPage('timeline', $eTimeline);

        // 3. output
        return $page->render();
    }

}
