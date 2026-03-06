<?php
namespace Hurah\Canvas\Endpoints\Account;


use DateTime;

/**
 * @property int $id The ID of the Account object
 * @property string $name The display name of the account
 * @property string $uuid The UUID of the account
 * @property int|null $parent_account_id The account's parent ID, or null if root
 * @property int|null $root_account_id The ID of the root account, or null if root
 * @property int $default_storage_quota_mb The storage quota for the account in MB
 * @property int $default_user_storage_quota_mb The storage quota for a user in MB
 * @property int $default_group_storage_quota_mb The storage quota for a group in MB
 * @property string $default_time_zone Default time zone (IANA or Rails format)
 * @property string|null $sis_account_id The account's SIS ID (if permitted)
 * @property string|null $integration_id The integration ID (if permitted)
 * @property int|null $sis_import_id The SIS import id (if available)
 * @property int|null $course_count Number of courses directly under account
 * @property int|null $sub_account_count Number of sub-accounts directly under account
 * @property string|null $lti_guid LTI GUID identifier
 * @property string $workflow_state Workflow state ('active' or 'deleted')
 */
class Account
{
    private int $id;
    private string $name;
    private string $uuid;
    private ?int $parent_account_id = null;
    private ?int $root_account_id = null;
    private int $default_storage_quota_mb;
    private int $default_user_storage_quota_mb;
    private int $default_group_storage_quota_mb;
    private string $default_time_zone;
    private ?string $sis_account_id = null;
    private ?string $integration_id = null;
    private ?int $sis_import_id = null;
    private ?int $course_count = null;
    private ?int $sub_account_count = null;
    private ?string $lti_guid = null;
    private string $workflow_state;

    public function __construct(
        int $id,
        string $name,
        string $uuid,
        ?int $parent_account_id,
        ?int $root_account_id,
        int $default_storage_quota_mb,
        int $default_user_storage_quota_mb,
        int $default_group_storage_quota_mb,
        string $default_time_zone,
        ?string $sis_account_id,
        ?string $integration_id,
        ?int $sis_import_id,
        ?int $course_count,
        ?int $sub_account_count,
        ?string $lti_guid,
        string $workflow_state
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->uuid = $uuid;
        $this->parent_account_id = $parent_account_id;
        $this->root_account_id = $root_account_id;
        $this->default_storage_quota_mb = $default_storage_quota_mb;
        $this->default_user_storage_quota_mb = $default_user_storage_quota_mb;
        $this->default_group_storage_quota_mb = $default_group_storage_quota_mb;
        $this->default_time_zone = $default_time_zone;
        $this->sis_account_id = $sis_account_id;
        $this->integration_id = $integration_id;
        $this->sis_import_id = $sis_import_id;
        $this->course_count = $course_count;
        $this->sub_account_count = $sub_account_count;
        $this->lti_guid = $lti_guid;
        $this->workflow_state = $workflow_state;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['uuid'],
            $data['parent_account_id'] ?? null,
            $data['root_account_id'] ?? null,
            $data['default_storage_quota_mb'],
            $data['default_user_storage_quota_mb'],
            $data['default_group_storage_quota_mb'],
            $data['default_time_zone'],
            $data['sis_account_id'] ?? null,
            $data['integration_id'] ?? null,
            $data['sis_import_id'] ?? null,
            $data['course_count'] ?? null,
            $data['sub_account_count'] ?? null,
            $data['lti_guid'] ?? null,
            $data['workflow_state']
        );
    }

    public function toArray(): array
    {
        return [
            'id'                           => $this->id,
            'name'                         => $this->name,
            'uuid'                         => $this->uuid,
            'parent_account_id'            => $this->parent_account_id,
            'root_account_id'              => $this->root_account_id,
            'default_storage_quota_mb'     => $this->default_storage_quota_mb,
            'default_user_storage_quota_mb'=> $this->default_user_storage_quota_mb,
            'default_group_storage_quota_mb'=> $this->default_group_storage_quota_mb,
            'default_time_zone'            => $this->default_time_zone,
            'sis_account_id'               => $this->sis_account_id,
            'integration_id'               => $this->integration_id,
            'sis_import_id'                => $this->sis_import_id,
            'course_count'                 => $this->course_count,
            'sub_account_count'            => $this->sub_account_count,
            'lti_guid'                     => $this->lti_guid,
            'workflow_state'               => $this->workflow_state,
        ];
    }

    // Getters (add setters too if you want mutability)
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getUuid(): string { return $this->uuid; }
    public function getParentAccountId(): ?int { return $this->parent_account_id; }
    public function getRootAccountId(): ?int { return $this->root_account_id; }
    public function getDefaultStorageQuotaMb(): int { return $this->default_storage_quota_mb; }
    public function getDefaultUserStorageQuotaMb(): int { return $this->default_user_storage_quota_mb; }
    public function getDefaultGroupStorageQuotaMb(): int { return $this->default_group_storage_quota_mb; }
    public function getDefaultTimeZone(): string { return $this->default_time_zone; }
    public function getSisAccountId(): ?string { return $this->sis_account_id; }
    public function getIntegrationId(): ?string { return $this->integration_id; }
    public function getSisImportId(): ?int { return $this->sis_import_id; }
    public function getCourseCount(): ?int { return $this->course_count; }
    public function getSubAccountCount(): ?int { return $this->sub_account_count; }
    public function getLtiGuid(): ?string { return $this->lti_guid; }
    public function getWorkflowState(): string { return $this->workflow_state; }

    /**
     * @param int $id
     * @return Account
     */
    public function setId(int $id): Account
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $name
     * @return Account
     */
    public function setName(string $name): Account
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $uuid
     * @return Account
     */
    public function setUuid(string $uuid): Account
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @param int|null $parent_account_id
     * @return Account
     */
    public function setParentAccountId(?int $parent_account_id): Account
    {
        $this->parent_account_id = $parent_account_id;
        return $this;
    }

    /**
     * @param int|null $root_account_id
     * @return Account
     */
    public function setRootAccountId(?int $root_account_id): Account
    {
        $this->root_account_id = $root_account_id;
        return $this;
    }

    /**
     * @param int $default_storage_quota_mb
     * @return Account
     */
    public function setDefaultStorageQuotaMb(int $default_storage_quota_mb): Account
    {
        $this->default_storage_quota_mb = $default_storage_quota_mb;
        return $this;
    }

    /**
     * @param int $default_user_storage_quota_mb
     * @return Account
     */
    public function setDefaultUserStorageQuotaMb(int $default_user_storage_quota_mb): Account
    {
        $this->default_user_storage_quota_mb = $default_user_storage_quota_mb;
        return $this;
    }

    /**
     * @param int $default_group_storage_quota_mb
     * @return Account
     */
    public function setDefaultGroupStorageQuotaMb(int $default_group_storage_quota_mb): Account
    {
        $this->default_group_storage_quota_mb = $default_group_storage_quota_mb;
        return $this;
    }

    /**
     * @param string $default_time_zone
     * @return Account
     */
    public function setDefaultTimeZone(string $default_time_zone): Account
    {
        $this->default_time_zone = $default_time_zone;
        return $this;
    }

    /**
     * @param string|null $sis_account_id
     * @return Account
     */
    public function setSisAccountId(?string $sis_account_id): Account
    {
        $this->sis_account_id = $sis_account_id;
        return $this;
    }

    /**
     * @param string|null $integration_id
     * @return Account
     */
    public function setIntegrationId(?string $integration_id): Account
    {
        $this->integration_id = $integration_id;
        return $this;
    }

    /**
     * @param int|null $sis_import_id
     * @return Account
     */
    public function setSisImportId(?int $sis_import_id): Account
    {
        $this->sis_import_id = $sis_import_id;
        return $this;
    }

    /**
     * @param int|null $course_count
     * @return Account
     */
    public function setCourseCount(?int $course_count): Account
    {
        $this->course_count = $course_count;
        return $this;
    }

    /**
     * @param int|null $sub_account_count
     * @return Account
     */
    public function setSubAccountCount(?int $sub_account_count): Account
    {
        $this->sub_account_count = $sub_account_count;
        return $this;
    }

    /**
     * @param string|null $lti_guid
     * @return Account
     */
    public function setLtiGuid(?string $lti_guid): Account
    {
        $this->lti_guid = $lti_guid;
        return $this;
    }

    /**
     * @param string $workflow_state
     * @return Account
     */
    public function setWorkflowState(string $workflow_state): Account
    {
        $this->workflow_state = $workflow_state;
        return $this;
    }


}
