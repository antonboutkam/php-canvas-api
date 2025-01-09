<?php

namespace Hurah\Canvas;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Endpoints\Assignment\Assignment;
use Hurah\Canvas\Endpoints\Assignment\AssignmentCollection;
use Hurah\Canvas\Endpoints\AssignmentGroup\AssignmentGroupCollection;
use Hurah\Canvas\Endpoints\Course\Course;
use Hurah\Canvas\Endpoints\Course\CourseCollection;
use Hurah\Canvas\Endpoints\GradingStandard\GradingStandard;
use Hurah\Canvas\Endpoints\Module\Module;
use Hurah\Canvas\Endpoints\Module\ModuleCollection;
use Hurah\Canvas\Endpoints\ModuleItem\ModuleItem;
use Hurah\Canvas\Endpoints\ModuleItem\ModuleItemCollection;
use Hurah\Canvas\Endpoints\Page\Page;
use Hurah\Canvas\Endpoints\Page\PageCollection;
use Hurah\Canvas\Endpoints\Submission\Submission;
use Hurah\Canvas\Endpoints\Submission\SubmissionCollection;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Util\JsonUtils;
use Hurah\Types\Type\Url;

class Canvas
{
    /**
     * GET /api/v1/courses/:course_id/assignment_groups
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getAssignmentGroups(int $iCanvasCourseId, int $iLimit = 100): AssignmentGroupCollection
    {
        $data = $this->getCollection("/courses/{$iCanvasCourseId}/assignment_groups", $iLimit);

        return AssignmentGroupCollection::fromCanvasArray($data, $iCanvasCourseId);
    }

    /**
     * GET /api/v1/courses/:course_id/assignment_groups/:assignment_group_id/assignments
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getAssignmentGroupAssignments(int $iCourseId, int $iAssignmentGroupId, int $iLimit = 100): AssignmentCollection
    {
        $data = $this->getCollection("/courses/{$iCourseId}/assignment_groups/{$iAssignmentGroupId}/assignments", $iLimit);
        return AssignmentCollection::fromCanvasArray($data);
    }

    /**
     * GET /courses/:course_id/students/submissions
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getCourseSubmissions(int $iCourseId, string $sWorkflowState = 'pending_review',int $iLimit = 100): SubmissionCollection
    {

        $sUrl = "/courses/{$iCourseId}/students/submissions";

        $data = $this->getCollection($sUrl, $iLimit);
        return new SubmissionCollection();
       // return SubmissionCollection::fromCanvasArray($data, $assignment);
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getSubmissions(int $iCourseId, int $iAssignmentId, string $sWorkflowState = 'pending_review',int $iLimit = 100): SubmissionCollection
    {
        $assignment = $this->getAssignment($iCourseId, $iAssignmentId);
        $sUrl = "/courses/{$iCourseId}/assignments/{$iAssignmentId}/submissions";


        $data = $this->getCollection($sUrl, $iLimit);

        return SubmissionCollection::fromCanvasArray($data, $assignment);
    }

    public function createGradingStandard(GradingStandard $oGradingStandard):array
    {
        $iAccountId = Config::getAccountId();
        $url = "/api/v1/accounts/{$iAccountId}/grading_standards";
        return $this->postItem($url, $oGradingStandard->toCanvasArray());
    }

    public function createCourse(Course $oCourse):array
    {
        $iAccountId = Config::getAccountId();
        $url = "/api/v1/accounts/{$iAccountId}/courses";
        return $this->postItem($url, $oCourse->toCanvasArray());

    }
    public function createSubmission(mixed $iCourseId, mixed $oAssignmentId, Submission $submission):array
    {
        $url = "/courses/{$iCourseId}/assignments/{$oAssignmentId}/submissions";
        return $this->postItem($url, $submission->toCanvasArray());
    }

    /**
     * PUT /api/v1/courses/:course_id/modules
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function createAssignment(int $iCourseId, Assignment $oAssignment): array
    {
        return $this->postItem("/courses/{$iCourseId}/assignments", $oAssignment->toCanvasArray());
    }

    public function updateAssignment(int $iCourseId, Assignment $oAssignment):array
    {
        return $this->putItem("/courses/{$iCourseId}/assignments/{$oAssignment->getId()}", $oAssignment->toCanvasArray());
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function storeAssignment(int $iCourseId, Assignment $oAssignment):array
    {
        if($oAssignment->getId())
        {
            return $this->updateAssignment($iCourseId, $oAssignment);
        }
        return $this->createAssignment($iCourseId, $oAssignment);
    }

    /**
     * Creates or updates a module depending on the existence of a module id in the Module object
     * @param int $iCourseId
     * @param Module $module
     * @return array
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function storeModule(int $iCourseId, Module $module):array
    {
        if($module->getId())
        {
            return $this->updateModule($iCourseId, $module->getId(), $module);
        }
        return $this->createModule($iCourseId, $module);
    }
    /**
     * PUT /api/v1/courses/:course_id/modules
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function updateModule(int $iCourseId, int $iModuleId, Module $module): array
    {
        return $this->putItem('/courses/' . $iCourseId . '/modules/' . $iModuleId, $module->toCanvasArray());
    }
    /**
     * PUT /api/v1/courses/:course_id/modules
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function createModule(int $iCourseId, Module $module): array
    {
        return $this->postItem('/courses/' . $iCourseId . '/modules', $module->toCanvasArray());
    }
    public function getPage(int $iCourseId, int $iPageId):Page
    {
        $data = $this->getItem("/courses/{$iCourseId}/pages/{$iPageId}");
        return Page::fromCanvasArray($data);
    }
    public function deletePage(int $iCourseId, int $iPageId):array
    {
        return $this->deleteItem("/courses/{$iCourseId}/pages/{$iPageId}");
    }
    public function storePage(int $iCourseId, Page $oPage):array
    {
        if($oPage->getPageId())
        {
            return $this->updatePage($iCourseId, $oPage);
        }
        return $this->createPage($iCourseId, $oPage);
    }
    public function createPage(int $iCourseId, Page $oPage):array
    {
        return $this->postItem("/courses/{$iCourseId}/pages", $oPage->toCanvasArray());
    }
    public function updatePage(int $iCourseId, Page $oPage):array
    {
        return $this->putItem("/courses/{$iCourseId}/pages/{$oPage->getPageId()}", $oPage->toCanvasArray());
    }
    public function getPages(int $iCourseId, int $iLimit = 100):PageCollection
    {
        $data = $this->getCollection("/courses/{$iCourseId}/pages", $iLimit);
        $collection = PageCollection::fromCanvasArray($data);
        return $collection;
    }
    public function deleteModule(int $iCourseId, int $iModuleId):array
    {
        return $this->deleteItem("/courses/{$iCourseId}/modules/{$iModuleId}");
    }
    public function getModule(int $iCourseId, int $iModuleId): Module
    {
        $data = $this->getItem("/courses/{$iCourseId}/modules/{$iModuleId}");

        return Module::fromCanvasArray($data);
    }
    /**
     * GET /api/v1/courses/:course_id/modules
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getModules(int $iCourseId, int $iLimit = 100): ModuleCollection
    {
        $data = $this->getCollection("/courses/{$iCourseId}/modules", $iLimit);

        $collection = ModuleCollection::fromCanvasArray($data);

        return $collection;
    }
    public function deleteModuleItem(int $iCourseId, int $iModuleId, int $iModuleItemId):array
    {
        $sUrl = "/courses/{$iCourseId}/modules/{$iModuleId}/items/{$iModuleItemId}";
        return $this->deleteItem($sUrl);
    }
    public function getModuleItem(int $iCourseId, int $iModuleId, int $iModuleItemId): ModuleItem
    {
        $data = $this->getItem("/courses/{$iCourseId}/modules/{$iModuleId}/items/{$iModuleItemId}");

        return ModuleItem::fromCanvasArray($data);
    }
    /**
     * GET /api/v1/courses/:course_id/modules
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getModuleItems(int $iCourseId, int $iModuleId, int $iLimit = 100): ModuleItemCollection
    {
        $data = $this->getCollection("/courses/{$iCourseId}/modules/{$iModuleId}/items", $iLimit);

        $collection = ModuleItemCollection::fromCanvasArray($data);

        return $collection;
    }
    public function storeModuleItem(int $iCourseId, int $iModuleId, ModuleItem $oModuleItem):array{
        if($oModuleItem->getId())
        {
            return $this->updateModuleItem($iCourseId, $iModuleId, $oModuleItem->getId(), $oModuleItem);
        }
        return $this->createModuleItem($iCourseId, $iModuleId, $oModuleItem);
    }
    public function updateModuleItem(int $iCourseId, int $iModuleId, int $iModuleItemId, ModuleItem $oModuleItem): array
    {
        $url = "/courses/{$iCourseId}/modules/{$iModuleId}/items/{$iModuleItemId}";
        return $this->putItem($url, $oModuleItem->toCanvasArray());
    }
    public function createModuleItem(int $iCourseId, int $iModuleId, ModuleItem $oModuleItem): array
    {
        $url = "/courses/{$iCourseId}/modules/{$iModuleId}/items";
        return $this->postItem($url, $oModuleItem->toCanvasArray());
    }
    /**
     * GET /courses/:course_id/assignments/:id
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getAssignment(int $iCourseId, int $iAssignmentId): Assignment
    {
        $data = $this->getItem("/courses/{$iCourseId}/assignments/{$iAssignmentId}");

        $oAssignment = Assignment::fromCanvasArray($data);
        return $oAssignment;
    }
    /**
     * GET /api/v1/courses/:course_id/assignments
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getAssignments(int $iCourseId, int $iLimit = 100): AssignmentCollection
    {
        $data = $this->getCollection("/courses/{$iCourseId}/assignments", $iLimit);

        $collection = AssignmentCollection::fromCanvasArray($data);

/*
        foreach ($collection as $assignment) {
            echo $assignment->getName() . '----' . $assignment->getId() . ' ---- ' . $assignment->getHtmlUrl() . PHP_EOL;
        }
*/
        return $collection;
    }
    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getCourse(int $iCourseId): Course
    {
        $data = $this->getItem("/courses/{$iCourseId}" );

        return Course::fromArray($data);
    }
    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getCourses(int $iLimit = 100): CourseCollection
    {
        $data = $this->getCollection('/courses', $iLimit);

        return CourseCollection::fromCanvasArray($data);
    }
    /**
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    private function getItem(string $endpoint): array
    {
        $headers = [
            'Authorization' => 'Bearer ' . Config::getCanvasToken()
        ];
        $options = [
            'headers' => $headers
        ];

        $url = Config::getCanvasUrl()->addPath("/api/v1{$endpoint}");

        return $this->apiCall($url, $options);
    }
    /**
     * @param Url $url
     * @param array $options
     * @return mixed|null
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    private function apiCall(Url $url, array $options)
    {
        $content = '{}';
        $client = new Client();
        try {
            $response = $client->request('GET', (string)$url, $options);

            $content = $response->getBody()->getContents();
        } catch (Exception $e) {
            echo $e->getFile() . ':' . $e->getLine() . PHP_EOL . $e->getMessage();
        }

        return JsonUtils::decode($content);
    }

    private function postItem(string $endpoint, array $item)
    {
        return $this->sendItem($endpoint, $item, 'POST');
    }

    /**
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    private function getCollection(string $endpoint, int $iItemsPerPage = 10): array
    {
        $headers = [
            'Authorization' => 'Bearer ' . Config::getCanvasToken()
        ];
        $options = [
            'headers' => $headers
        ];

        $url = Config::getCanvasUrl()->addPath("/api/v1{$endpoint}");
        $url->addQuery(['per_page' => $iItemsPerPage]);
        return $this->apiCall($url, $options);
    }

    private function putItem(string $endpoint, array $item): array
    {
        return $this->sendItem($endpoint, $item, 'PUT');
    }

    private function deleteItem(string $endpoint):array
    {
        $headers = [
            'Authorization' => 'Bearer ' . Config::getCanvasToken()
        ];
        $options = [
            'headers' => $headers
        ];
        $url = (string)Config::getCanvasUrl()->addPath("/api/v1{$endpoint}");
        $client = new Client();
        try {

            $response = $client->request('DELETE', (string)$url, $options);


            echo 'STATUS ' . $response->getStatusCode() . PHP_EOL;

            return JsonUtils::decode($response->getBody());
        } catch (Exception $e) {
            echo $e->getFile() . ':' . $e->getLine() . PHP_EOL . $e->getMessage();
        }
        return [];

    }

    private function sendItem(string $endpoint, array $item, string $method)
    {
        $headers = [
            'Authorization' => 'Bearer ' . Config::getCanvasToken()
        ];

        $options = [
            'headers' => $headers,
            'form_params' => $item
        ];
        $url = (string)Config::getCanvasUrl()->addPath("/api/v1{$endpoint}");
        $client = new Client();
        try {

            $response = $client->request($method, (string)$url, $options);


            echo 'STATUS ' . $response->getStatusCode() . PHP_EOL;

            return JsonUtils::decode($response->getBody());
        } catch (Exception $e) {
            echo $e->getFile() . ':' . $e->getLine() . PHP_EOL . $e->getMessage();
        }
        return [];
    }

}