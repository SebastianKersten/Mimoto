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

    public function viewCourses(Application $app)
    {
        // 1. load data
        $eContentSection = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_CONTENTSECTION, 'value' => ['name' => 'Courses']]);

        // 2. create template
        $page = Mimoto::service('output')->createPage('courseOverview', (!empty($eContentSection)) ? $eContentSection[0] : '');

        // 3. output
        return $page->render();

    }

    public function viewCourse(Application $app, $nCourseId, $nSlideIndex = 0)
    {
        // 1. load course
        $eCourse = Mimoto::service('data')->get('course', $nCourseId);

        // 2. get slides
        $aSlides = $eCourse->getValue('slides');

        // 3. validate
        if (count($aSlides) == 0) die ('Please add a slide to this course');

        // 4. validate
        if (!isset($aSlides[$nSlideIndex])) die ('The slide you are looking for is not here');

        // 5. register
        $eSlide = $aSlides[$nSlideIndex];

        // 6. create template
        $page = Mimoto::service('output')->createPage('slide', $eSlide);

        // 7. output
        return $page->render();
    }


    public function viewGrid(Application $app)
    {
        // 1. create page
        $page = Mimoto::service('output')->createPage('grid');

        // 2. output
        return $page->render();
    }

}
