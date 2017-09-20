<?php

// classpath
namespace Mimoto\UserInterface\docs;

// Mimoto classes
use Mimoto\Mimoto;
use Mimoto\Core\CoreConfig;

// Silex classes
use Silex\Application;

// Symfony classes
use Symfony\Component\HttpFoundation\Request;


/**
 * DocsController
 *
 * @author Sebastian Kersten (@supertaboo)
 */
class DocsController
{

    public function testDefaultValue(Application $app)
    {
        $eComment = Mimoto::service('data')->create('comment');

        //$eComment->set('message', 'Hallo');

        Mimoto::service('data')->store($eComment);



        Mimoto::error($eComment);

        return 'xxx';
    }



    public function viewDocs(Application $app)
    {
        // 1. load data
        $eContentSection = Mimoto::service('data')->find(['type' => CoreConfig::MIMOTO_DATASET, 'value' => ['name' => 'Courses']]);

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

        // 7. setup
        $page->setVar('nCourseId', $nCourseId);
        $page->setVar('sCourseName', $eCourse->getValue('name'));
        $page->setVar('nSlideIndex', $nSlideIndex + 1);
        $page->setVar('nSlideCount', count($aSlides));
        $page->setVar('nPreviousSlide', $nSlideIndex - 1);
        $page->setVar('nNextSlide', $nSlideIndex + 1);

        // 8. output
        return $page->render();
    }

}
