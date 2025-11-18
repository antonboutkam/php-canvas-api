<?php

namespace Hurah\Canvas;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Hurah\Canvas\Endpoints\Account\AccountCollection;
use Hurah\Canvas\Endpoints\Assignment\Assignment;
use Hurah\Canvas\Endpoints\Assignment\AssignmentCollection;
use Hurah\Canvas\Endpoints\AssignmentGroup\AssignmentGroup;
use Hurah\Canvas\Endpoints\AssignmentGroup\AssignmentGroupCollection;
use Hurah\Canvas\Endpoints\Course\Course;
use Hurah\Canvas\Endpoints\Course\CourseCollection;
use Hurah\Canvas\Endpoints\File\File;
use Hurah\Canvas\Endpoints\File\FileCollection;
use Hurah\Canvas\Endpoints\Folder\Folder;
use Hurah\Canvas\Endpoints\Folder\FolderCollection;
use Hurah\Canvas\Endpoints\GradingStandard\GradingStandard;
use Hurah\Canvas\Endpoints\Module\Module;
use Hurah\Canvas\Endpoints\Module\ModuleCollection;
use Hurah\Canvas\Endpoints\ModuleItem\ModuleItem;
use Hurah\Canvas\Endpoints\ModuleItem\ModuleItemCollection;
use Hurah\Canvas\Endpoints\Page\Page;
use Hurah\Canvas\Endpoints\Page\PageCollection;
use Hurah\Canvas\Endpoints\Quiz\Quiz;
use Hurah\Canvas\Endpoints\Quiz\QuizCollection;
use Hurah\Canvas\Endpoints\QuizQuestion\QuizQuestion;
use Hurah\Canvas\Endpoints\QuizQuestion\QuizQuestionCollection;
use Hurah\Canvas\Endpoints\QuizQuestionGroup\QuizQuestionGroup;
use Hurah\Canvas\Endpoints\Student\Student;
use Hurah\Canvas\Endpoints\Student\StudentCollection;
use Hurah\Canvas\Endpoints\Submission\Submission;
use Hurah\Canvas\Endpoints\Submission\SubmissionCollection;
use Hurah\Canvas\Endpoints\User\UserCollection;
use Hurah\Types\Exception\InvalidArgumentException;
use Hurah\Types\Type\Url;
use Hurah\Types\Util\JsonUtils;

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
    private function getCollection(string $endpoint, int $iItemsPerPage = 10, array $aOptionalArguments = []): array
    {
        $headers = [
            'Authorization' => 'Bearer ' . Config::getCanvasToken()
        ];
        $options = [
            'headers' => $headers
        ];

        $url = Config::getCanvasUrl()->addPath("/api/v1{$endpoint}");
        $url->addQuery(['per_page' => $iItemsPerPage]);

        if (isset($aOptionalArguments['GET']) && is_array($aOptionalArguments['GET'])) {
            $url->addQuery($aOptionalArguments['GET']);
        }

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
    public function getCourseSubmissions(int $iCourseId, string $sWorkflowState = 'pending_review', int $iLimit = 100): SubmissionCollection
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
    public function getSubmissions(int $iCourseId, int $iAssignmentId, string|int $mWorkflowState = 'pending_review', int $iLimit = 100): SubmissionCollection
    {
        $assignment = $this->getAssignment($iCourseId, $iAssignmentId);
        $sUrl = "/courses/{$iCourseId}/assignments/{$iAssignmentId}/submissions";

        if (is_int($mWorkflowState)) {
            $iLimit = $mWorkflowState;
            $sWorkflowState = 'pending_review';
        } else {
            $sWorkflowState = $mWorkflowState;
        }

        $data = $this->getCollection($sUrl, $iLimit, ['GET' => ['workflow_state' => $sWorkflowState]]);

        return SubmissionCollection::fromCanvasArray($data, $assignment);
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
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getStudentsInCourse(int $iCourseId): StudentCollection
    {
        $url = "/courses/{$iCourseId}/users";
        $aArguments = ['GET' => ['enrollment_type' => 'student']];
        return StudentCollection::fromCanvasArray($this->getCollection($url, 100, $aArguments));
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function getUserProfile(int $iUserId): array
    {
        $url = "/users/{$iUserId}/profile";
        return $this->getItem($url);
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function getUsersInAccount(): UserCollection
    {
        $iAccountId = Config::getAccountId();
        $url = "/accounts/self/users";
        $aUsers = $this->getCollection($url);
        return UserCollection::fromCanvasArray($aUsers);
    }

    /**
     * @param int $iUserId
     * @return CourseCollection
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function getUserCourses(int $iUserId): CourseCollection
    {
        $url = "/users/{$iUserId}/courses";
        $aCourses = $this->getCollection($url);
        return CourseCollection::fromCanvasArray($aCourses);
    }

    /**
     * @param GradingStandard $oGradingStandard
     * @return array
     */
    public function createGradingStandard(GradingStandard $oGradingStandard): array
    {
        $iAccountId = Config::getAccountId();
        $url = "/accounts/{$iAccountId}/grading_standards";
        // $oGradingStandard->toCanvasArray()
        return $this->postItem($url, $oGradingStandard->toCanvasArray());
    }

    private function postItem(string $endpoint, array $item)
    {
        return $this->sendItem($endpoint, $item, 'POST');
    }

    private function sendFileCloudStorage(string $sUrl, array $aPostData):?array
    {
        $client = new Client();
        $options = [
            'form_params' => $aPostData
        ];
        $response = $client->request('POST', $sUrl, $options);
        $mUrl = $response->getHeader('Location');

        $oUrl = new Url($sUrl);
        if(is_array($mUrl))
        {
            $sUrl = array_shift($mUrl);
            $sUrl = str_replace('https://canvas.instructure.com/api/v1', '', $sUrl);
        }

        echo 'Calling:' .  $sUrl . PHP_EOL;
        // $oEndpointUrl = new Url($sEndPoint);
        // $sEndpoint = $oEndpointUrl->addQuery($oUrl->getQuery());
        return $this->getItem($sUrl);

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

    public function createCourse(Course $oCourse): array
    {
        $iAccountId = Config::getAccountId();
        $url = "/accounts/{$iAccountId}/courses";
        return $this->postItem($url, $oCourse->toCanvasArray());

    }

    /**
     * @param mixed $iCourseId
     * @param mixed $oAssignmentId
     * @param Submission $submission
     * @return array
     */
    public function createSubmission(mixed $iCourseId, mixed $oAssignmentId, Submission $submission): array
    {
        $url = "/courses/{$iCourseId}/assignments/{$oAssignmentId}/submissions";
        return $this->postItem($url, $submission->toCanvasArray());
    }

    /**
     * @param int $iCourseId
     * @param AssignmentGroup $oAssignmentGroup
     * @return array
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function storeAssignmentGroup(int $iCourseId, Endpoints\AssignmentGroup\AssignmentGroup $oAssignmentGroup): array
    {
        if ($oAssignmentGroup->getId()) {
            $this->updateAssignmentGroup($iCourseId, $oAssignmentGroup->getId(), $oAssignmentGroup);
        }
        return $this->createAssignmentGroup($iCourseId, $oAssignmentGroup);

    }

    /**
     * @param int $iCourseId
     * @param int $iAssignmentGroupId
     * @param AssignmentGroup $oAssignmentGroup
     * @return array
     */
    public function updateAssignmentGroup(int $iCourseId, int $iAssignmentGroupId, Endpoints\AssignmentGroup\AssignmentGroup $oAssignmentGroup): array
    {
        return $this->putItem("/courses/{$iCourseId}/assignment_groups/{$iAssignmentGroupId}", $oAssignmentGroup->toCanvasArray());
    }

    private function putItem(string $endpoint, array $item): array
    {
        return $this->sendItem($endpoint, $item, 'PUT');
    }

    /**
     * PUT /api/v1/courses/:course_id/modules
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function createAssignmentGroup(int $iCourseId, Endpoints\AssignmentGroup\AssignmentGroup $oAssignmentGroup): array
    {
        return $this->postItem("/courses/{$iCourseId}/assignment_groups", $oAssignmentGroup->toCanvasArray());
    }

    /**
     * @param int $iCourseId
     * @param int $iAssignmentGroupId
     * @return array
     */
    public function deleteAssignmentGroup(int $iCourseId, int $iAssignmentGroupId): array
    {
        return $this->deleteItem("/courses/{$iCourseId}/assignment_groups/{$iAssignmentGroupId}");
    }

    private function deleteItem(string $endpoint): array
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

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function getAssignmentGroup(int $iCourseId, int $iAssignmentGroup): AssignmentGroup
    {
        $aAssignmentGroup = $this->getItem("/courses/{$iCourseId}/assignment_groups/{$iAssignmentGroup}");
        $aAssignmentGroup['course_id'] = $iCourseId;

        return AssignmentGroup::fromCanvasArray($aAssignmentGroup);
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     */
    public function storeAssignment(int $iCourseId, Assignment $oAssignment): array
    {
        if ($oAssignment->getId()) {
            return $this->updateAssignment($iCourseId, $oAssignment->getId(), $oAssignment);
        }
        return $this->createAssignment($iCourseId, $oAssignment);
    }

    /**
     * @param int $iCourseId
     * @param int $iAssignmentId
     * @param Assignment $oAssignment
     * @return array
     */
    public function updateAssignment(int $iCourseId, int $iAssignmentId, Assignment $oAssignment): array
    {
        return $this->putItem("/courses/{$iCourseId}/assignments/{$iAssignmentId}", $oAssignment->toCanvasArray());
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

    /**
     * @param int $iCourseId
     * @param int $iLimit
     * @return QuizCollection
     * @throws GuzzleException
     * @throws InvalidArgumentException
     * @seee https://canvas.instructure.com/doc/api/quizzes.html#method.quizzes/quizzes_api.index
     */
    public function getQuizzes(int $iCourseId, int $iLimit = 100): QuizCollection
    {

        $sUrl = "/courses/{$iCourseId}/quizzes";
        $data = $this->getCollection($sUrl, $iLimit);

        return QuizCollection::fromCanvasArray($data);
    }

    /**
     * @param int $iCourseId
     * @param int $iQuizId
     * @param QuizQuestion $oQuizQuestion
     * @return QuizQuestionCollection
     * @throws Exception
     */
    public function getQuizQuestions(int $iCourseId, int $iQuizId): QuizQuestionCollection
    {
        $aQuizQuestionCollection = $this->getItem("/courses/{$iCourseId}/quizzes/{$iQuizId}/questions");
        return QuizQuestionCollection::fromCanvasArray($aQuizQuestionCollection);
    }

    /**
     * @param int $iCourseId
     * @param int $iQuizId
     * @param QuizQuestion $oQuizQuestion
     * @return array
     * @throws GuzzleException
     */
    public function getQuizQuestion(int $iCourseId, int $iQuizId, int $iQuizQuestionId): QuizQuestion
    {
        $aQuizQuestion = $this->getItem("/courses/{$iCourseId}/quizzes/{$iQuizId}/questions/{$iQuizQuestionId}");
        return QuizQuestion::fromCanvasArray($aQuizQuestion);
    }

    /**
     * @param int $iCourseId
     * @param int $iQuizId
     * @param QuizQuestion $oQuizQuestion
     * @return array
     */
    public function createQuizQuestion(int $iCourseId, int $iQuizId, QuizQuestion $oQuizQuestion): array
    {
        return $this->postItem("/courses/{$iCourseId}/quizzes/{$iQuizId}/questions", $oQuizQuestion->toCanvasArray());
    }

    public function storeQuizQuestion(int $iCourseId, int $iQuizId, QuizQuestion $oQuizQuestion): array
    {
        if ($oQuizQuestion->getId()) {
            $this->updateQuestion($iCourseId, $iQuizId, $oQuizQuestion->getId(), $oQuizQuestion);
        }
        return $this->storeQuizQuestion($iCourseId, $iQuizId, $oQuizQuestion);
    }

    /**
     * @param int $iCourseId
     * @param int $iQuizId
     * @param int $iQuizQuestionId
     * @param QuizQuestion $oQuizQuestion
     * @return array
     */
    public function updateQuestion(int $iCourseId, int $iQuizId, int $iQuizQuestionId, QuizQuestion $oQuizQuestion): array
    {
        return $this->putItem("/courses/{$iCourseId}/quizzes/{$iQuizId}/questions/{$iQuizQuestionId}", $oQuizQuestion->toCanvasArray());
    }

    /**
     * @param int $iCourseId
     * @param int $iQuizId
     * @param int $iQuizQuestionId
     * @return array
     * @see https://canvas.instructure.com/doc/api/quizzes.html#method.quizzes/quizzes_api.destroy
     */
    public function deleteQuizQuestion(int $iCourseId, int $iQuizId, int $iQuizQuestionId): array
    {
        return $this->deleteItem("/courses/{$iCourseId}/quizzes/{$iQuizId}/questions/{$iQuizQuestionId}");
    }

    /**
     * @param int $iCourseId
     * @param Quiz $oQuiz
     * @return array
     */
    public function storeQuiz(int $iCourseId, Quiz $oQuiz): array
    {
        if ($oQuiz->getId()) {
            $this->updateQuiz($iCourseId, $oQuiz->getId(), $oQuiz);
        }
        return $this->createQuiz($iCourseId, $oQuiz);
    }

    /**
     * @param int $iCourseId
     * @param int $iQuizId
     * @param Quiz $oQuiz
     * @return array
     * @see https://canvas.instructure.com/doc/api/quizzes.html#method.quizzes/quizzes_api.update
     */
    public function updateQuiz(int $iCourseId, int $iQuizId, Quiz $oQuiz): array
    {
        return $this->postItem("/courses/{$iCourseId}/quizzes/{$iQuizId}", $oQuiz->toCanvasArray());
    }

    /**
     * @param int $iCourseId
     * @param Quiz $oQuiz
     * @return array
     * @see https://canvas.instructure.com/doc/api/new_quizzes.html#method.new_quizzes/quizzes_api.create
     */
    public function createQuiz(int $iCourseId, Quiz $oQuiz): array
    {
        return $this->postItem("/courses/{$iCourseId}/quizzes", $oQuiz->toCanvasArray());
    }

    /**
     * @param int $iCourseId
     * @param int $iQuizId
     * @return array
     */
    public function deleteQuiz(int $iCourseId, int $iQuizId): array
    {
        return $this->deleteItem("courses/{$iCourseId}/quizzes/{$iQuizId}");
    }

    /**
     * @param int $iCourseId
     * @param int $iQuizId
     * @param QuizQuestionGroup $oQuizQuestionGroup
     * @return array
     */
    public function storeQuizQuestionGroup(int $iCourseId, int $iQuizId, QuizQuestionGroup $oQuizQuestionGroup): array
    {
        if ($oQuizQuestionGroup->getId()) {
            return $this->updateQuizQuestionGroup($iCourseId, $iQuizId, $oQuizQuestionGroup->getId(),
                $oQuizQuestionGroup);
        }
        return $this->createQuizQuestionGroup($iCourseId, $iQuizId, $oQuizQuestionGroup);
    }

    /**
     * @param int $iCourseId
     * @param int $iQuizId
     * @param int $iQuizGroupId
     * @param QuizQuestionGroup $oQuizQuestionGroup
     * @return array
     */
    public function updateQuizQuestionGroup(int $iCourseId, int $iQuizId, int $iQuizGroupId, QuizQuestionGroup $oQuizQuestionGroup): array
    {
        return $this->putItem("/courses/{$iCourseId}/quizzes/{$iQuizId}/groups/{$iQuizGroupId}", $oQuizQuestionGroup->toCanvasArray
        ());
    }

    /**
     * @param int $iCourseId
     * @param int $iQuizId
     * @param QuizQuestionGroup $oQuizQuestionGroup
     * @return array
     */
    public function createQuizQuestionGroup(int $iCourseId, int $iQuizId, QuizQuestionGroup $oQuizQuestionGroup): array
    {
        return $this->postItem("/courses/{$iCourseId}/quizzes/{$iQuizId}/groups", $oQuizQuestionGroup->toCanvasArray());
    }

    /**
     * Creates or updates a module depending on the existence of a module id in the Module object
     * @param int $iCourseId
     * @param Module $module
     * @return array
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function storeModule(int $iCourseId, Module $module): array
    {
        if ($module->getId()) {
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

    /**
     * @param int $iCourseId
     * @param int $iPageId
     * @return Page
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function getPage(int $iCourseId, int $iPageId): Page
    {
        $data = $this->getItem("/courses/{$iCourseId}/pages/{$iPageId}");
        return Page::fromCanvasArray($data);
    }

    /**
     * @param int $iCourseId
     * @param int $iPageId
     * @return array
     */
    public function deletePage(int $iCourseId, int $iPageId): array
    {
        return $this->deleteItem("/courses/{$iCourseId}/pages/{$iPageId}");
    }

    /**
     * @param int $iCourseId
     * @param Page $oPage
     * @return array
     */
    public function storePage(int $iCourseId, Page $oPage): array
    {
        if ($oPage->getPageId()) {
            return $this->updatePage($iCourseId, $oPage);
        }
        return $this->createPage($iCourseId, $oPage);
    }

    public function updatePage(int $iCourseId, Page $oPage): array
    {
        return $this->putItem("/courses/{$iCourseId}/pages/{$oPage->getPageId()}", $oPage->toCanvasArray());
    }

    public function createPage(int $iCourseId, Page $oPage): array
    {
        return $this->postItem("/courses/{$iCourseId}/pages", $oPage->toCanvasArray());
    }

    public function getPages(int $iCourseId, int $iLimit = 100): PageCollection
    {
        $data = $this->getCollection("/courses/{$iCourseId}/pages", $iLimit);
        $collection = PageCollection::fromCanvasArray($data);
        return $collection;
    }

    public function deleteModule(int $iCourseId, int $iModuleId): array
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

    public function deleteModuleItem(int $iCourseId, int $iModuleId, int $iModuleItemId): array
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

    public function storeModuleItem(int $iCourseId, int $iModuleId, ModuleItem $oModuleItem): array
    {
        if ($oModuleItem->getId()) {
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
        $data = $this->getItem("/courses/{$iCourseId}");
        return Course::fromArray($data);
    }

    public function getCourseUsers(int $iCourseId, int $iLimit = 100, string $sType = 'student'): UserCollection
    {
        $data = $this->getCollection('/courses/' . $iCourseId . '/users?enrollment_type=' . $sType, $iLimit);
        return UserCollection::fromCanvasArray($data);
    }

    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getAccounts(int $iLimit = 100): AccountCollection
    {
        $data = $this->getCollection('/accounts', $iLimit);
        return AccountCollection::fromCanvasArray($data);

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
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getFiles(int $iCourseId): FileCollection
    {
        $data = $this->getCollection('/courses/' . $iCourseId . '/files');

        return FileCollection::fromCanvasArray($data);
    }
    public function getFile(int $iCourseId, int $iFileId):File
    {
        return File::fromCanvasArray($this->getItem('/courses/' . $iCourseId . '/files/' . $iFileId));
    }
    public function uploadFileFromUrl(int $iCourseId, string $sFileName, string $sParentFolderPath, string $sContentType, string $sUrl, int $iFileSize):File
    {
        $aData = [
            'url' => $sUrl,
            'name' => $sFileName,
            'size' => $iFileSize,
            'content_type' => $sContentType,
            'parent_folder_path' => $sParentFolderPath
        ];
        $response = $this->postItem('/courses/' . $iCourseId . '/files/', $aData);
        echo "Canvas response: " . PHP_EOL;
        print_r($response);
        if(isset($response['upload_url']))
        {
            echo "Send file cloud storage" . PHP_EOL;
            $response2 = $this->sendFileCloudStorage($response['upload_url'], $response['upload_params']);
            print_r($response2);
        }

        // courses/:course_id/files
        return File::fromCanvasArray($response2);
    }

    /**
     *
     * @param int $iCourseId course id
     * @param string $sFileName The filename of the file. Any UTF-8 name is allowed. Path components such as `/` and
     *     `\` will be treated as part of the filename, not a path to a sub-folder.
     * @param string $sFolderPath The path of the folder to store the file in. The path separator is the forward slash
     *     `/`, never a back slash. The folder will be created if it does not already exist. This parameter only
     *     applies to file uploads in a context that has folders, such as a user, a course, or a group. If this and
     *     parent_folder_id are sent an error will be returned. If neither is given, a default folder will be used.
     * @param int $sSizeInBytes The size of the file, in bytes. This field is recommended, as it will let you find out
     *     if there's a quota issue before uploading the raw file.
     * @param string $sContentType The content type of the file. If not given, it will be guessed based on the file
     *     extension.
     * @param string $sOnDuplicate [overwrite|rename]
     * @param string $f
     * @return File
     * @throws GuzzleException
     * @throws InvalidArgumentException
     */
    public function uploadFile(int $iCourseId, string $sFileName, string $sFolderPath, int $sSizeInBytes, string $sContentType, string $sOnDuplicate, string $sContents):File
    {
        $item = [
            'name' => $sFileName,
            'size' => $sSizeInBytes,
            'content_type' => $sContentType,
            'parent_folder_path' => $sFolderPath,
            'on_duplicate' => $sOnDuplicate
        ];
        $result = $this->postItem('courses/' . $iCourseId . '/files/', $item);

        $postVars = [];
        if(isset($result['upload_params']))
        {
            $postVars = $result['upload_params'];
        }
        $postVars['file'] = $sContents;

        $aFile = $this->sendFileCloudStorage($result['upload_url'], $postVars);
        // courses/:course_id/files
        return File::fromCanvasArray($aFile);
    }
    /**
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws Exception
     */
    public function getFolders(int $iCourseId): FolderCollection

    {
        $data = $this->getCollection('/courses/' . $iCourseId . '/folders');

        return FolderCollection::fromCanvasArray($data);
    }
    public function getFolder(int $iCourseId, int $iFolderID):Folder
    {
        return Folder::fromCanvasArray($this->getItem('/courses/' . $iCourseId . '/files/' . $iFolderID));
    }
    public function createFolder(int $iCourseId, array $aFolder):Folder
    {
        $aFolder = $this->postItem('/courses/' . $iCourseId . '/folders', $aFolder);
        return Folder::fromCanvasArray($aFolder);
    }
    public function deleteFolder(int $iCourseId, int $iFolderId):void
    {
        $this->deleteItem('/courses/' . $iCourseId . '/folders/' . $iFolderId);
    }
}
