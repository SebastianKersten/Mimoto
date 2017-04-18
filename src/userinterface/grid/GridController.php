<?php

// classpath
namespace Mimoto\UserInterface\grid;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


/**
 * GridController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class GridController
{

    public function viewGrid(Application $app)
    {
        // 1. create page
        $page = Mimoto::service('output')->createPage('grid');

        // 2. output
        return $page->render();
    }

}
