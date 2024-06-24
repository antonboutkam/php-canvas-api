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
use Hurah\Canvas\Endpoints\Module\Module;
use Hurah\Canvas\Endpoints\Module\ModuleCollection;
use Hurah\Canvas\Endpoints\ModuleItem\ModuleItem;
use Hurah\Canvas\Endpoints\ModuleItem\ModuleItemCollection;
use Hurah\Canvas\Endpoints\Page\Page;
use Hurah\Canvas\Endpoints\Page\PageCollection;
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
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function getCollection(string $endpoint, int $iItemsPerPage = 10): array
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
        print_r($data);
        sleep(5);
    //    return SubmissionCollection::fromCanvasArray($data, $assignment);
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
print_r($data);
sleep(5);
        return SubmissionCollection::fromCanvasArray($data, $assignment);
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

    public function putItem(string $endpoint, array $item): array
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
     * PUT /api/v1/courses/:course_id/modules
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function createAssignment(int $iCourseId, Assignment $assignment): array
    {
        return $this->postItem('/courses/' . $iCourseId . '/modules', $assignment->toCanvasArray());
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

    public function postItem(string $endpoint, array $item)
    {
        return $this->sendItem($endpoint, $item, 'POST');
    }
    public function getPage(int $iCourseId, int $iPageId):Page
    {
        $data = $this->getItem("/courses/{$iCourseId}/pages/{$iPageId}");
        return Page::fromCanvasArray($data);
    }
    public function deleteModule(int $iCourseId, int $iModuleId):array
    {
        return $this->deleteItem("/courses/{$iCourseId}/modules/{$iModuleId}");
    }
    public function deletePage(int $iCourseId, int $iPageId):array
    {
        return $this->deleteItem("/courses/{$iCourseId}/pages/{$iPageId}");
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

    public function getModule(int $iCourseId, int $iModuleId): Module
    {
        $data = $this->getItem("/courses/{$iCourseId}/modules/{$iModuleId}");

        return Module::fromCanvasArray($data);
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


        foreach ($collection as $assignment) {
            echo $assignment->getName() . '----' . $assignment->getId() . ' ---- ' . $assignment->getHtmlUrl() . PHP_EOL;
        }

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
    public function getItem(string $endpoint): array
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
}