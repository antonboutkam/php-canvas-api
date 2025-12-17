<?php

namespace Hurah\Canvas\Endpoints\User;

use Hurah\Canvas\Endpoints\CanvasObject;


/**
 * Class User
 *
 * Represents a user entity with properties and methods to manage user information.
 */
class User extends CanvasObject
{
    // User properties
    private string $name;
    private string $shortName;
    private string $sortableName;
    private string $timeZone;
    private string $email;
    private string $locale;

    // Avatar properties
    private string $avatarToken;
    private string $avatarUrl;
    private string $avatarState;

    // Profile properties
    private string $title;
    private string $bio;
    private string $pronunciation;
    private string $pronouns;

    // Account properties
    private string $event;
    private bool $overrideSisStickiness;

    /**
     * Sets the full name of the user.
     *
     * @param string $name The full name of the user.
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets the full name of the user.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets the short name of the user.
     *
     * @param string $shortName User’s name as displayed in discussions, messages, and comments.
     * @return self
     */
    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;
        return $this;
    }

    /**
     * Gets the short name of the user.
     *
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }

    /**
     * Sets the sortable name of the user.
     *
     * @param string $sortableName User’s name for alphabetical sorting.
     * @return self
     */
    public function setSortableName(string $sortableName): self
    {
        $this->sortableName = $sortableName;
        return $this;
    }

    /**
     * Gets the sortable name of the user.
     *
     * @return string
     */
    public function getSortableName(): string
    {
        return $this->sortableName;
    }

    /**
     * Sets the user's time zone.
     *
     * @param string $timeZone IANA or Ruby on Rails compatible time zone.
     * @return self
     */
    public function setTimeZone(string $timeZone): self
    {
        $this->timeZone = $timeZone;
        return $this;
    }

    /**
     * Gets the user's time zone.
     *
     * @return string
     */
    public function getTimeZone(): string
    {
        return $this->timeZone;
    }

    /**
     * Sets the user's email address.
     *
     * @param string $email The default email address.
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Gets the user's email address.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Sets the user's preferred language.
     *
     * @param string $locale Language in RFC-5646 format.
     * @return self
     */
    public function setLocale(string $locale): self
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * Gets the user's preferred language.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Sets the user's avatar token.
     *
     * @param string $avatarToken Unique avatar token.
     * @return self
     */
    public function setAvatarToken(string $avatarToken): self
    {
        $this->avatarToken = $avatarToken;
        return $this;
    }

    /**
     * Gets the user's avatar token.
     *
     * @return string
     */
    public function getAvatarToken(): string
    {
        return $this->avatarToken;
    }

    /**
     * Sets the user's avatar URL.
     *
     * @param string $avatarUrl URL pointing to an external avatar.
     * @return self
     */
    public function setAvatarUrl(string $avatarUrl): self
    {
        $this->avatarUrl = $avatarUrl;
        return $this;
    }

    /**
     * Gets the user's avatar URL.
     *
     * @return string
     */
    public function getAvatarUrl(): string
    {
        return $this->avatarUrl;
    }

    /**
     * Sets the user's avatar state.
     *
     * @param string $avatarState Allowed values: none, submitted, approved, locked, reported, re_reported.
     * @return self
     */
    public function setAvatarState(string $avatarState): self
    {
        $this->avatarState = $avatarState;
        return $this;
    }

    /**
     * Gets the user's avatar state.
     *
     * @return string
     */
    public function getAvatarState(): string
    {
        return $this->avatarState;
    }

    /**
     * Sets the title on the user profile.
     *
     * @param string $title Profile title.
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Gets the title on the user profile.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the user's bio.
     *
     * @param string $bio Short biography.
     * @return self
     */
    public function setBio(string $bio): self
    {
        $this->bio = $bio;
        return $this;
    }

    /**
     * Gets the user's bio.
     *
     * @return string
     */
    public function getBio(): string
    {
        return $this->bio;
    }

    /**
     * Sets the name pronunciation.
     *
     * @param string $pronunciation Name pronunciation.
     * @return self
     */
    public function setPronunciation(string $pronunciation): self
    {
        $this->pronunciation = $pronunciation;
        return $this;
    }

    /**
     * Gets the name pronunciation.
     *
     * @return string
     */
    public function getPronunciation(): string
    {
        return $this->pronunciation;
    }

    /**
     * Sets the user's pronouns.
     *
     * @param string $pronouns Allowed pronouns set on the root account.
     * @return self
     */
    public function setPronouns(string $pronouns): self
    {
        $this->pronouns = $pronouns;
        return $this;
    }

    /**
     * Gets the user's pronouns.
     *
     * @return string
     */
    public function getPronouns(): string
    {
        return $this->pronouns;
    }

    /**
     * Sets the user's event status.
     *
     * @param string $event Allowed values: suspend, unsuspend.
     * @return self
     */
    public function setEvent(string $event): self
    {
        $this->event = $event;
        return $this;
    }

    /**
     * Gets the user's event status.
     *
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * Sets SIS stickiness override.
     *
     * @param bool $override Override flag.
     * @return self
     */
    public function setOverrideSisStickiness(bool $override): self
    {
        $this->overrideSisStickiness = $override;
        return $this;
    }

    /**
     * Gets SIS stickiness override status.
     *
     * @return bool
     */
    public function getOverrideSisStickiness(): bool
    {
        return $this->overrideSisStickiness;
    }

    /**
     * Creates a User instance from a Canvas API response array.
     *
     * @param array $data The associative array of user data.
     * @return self
     */
    public static function fromCanvasArray(array $data): self
    {
        $user = new self();
        return $user
            ->setName($data['name'] ?? '')
            ->setShortName($data['short_name'] ?? '')
            ->setSortableName($data['sortable_name'] ?? '')
            ->setTimeZone($data['time_zone'] ?? '')
            ->setEmail($data['email'] ?? '')
            ->setLocale($data['locale'] ?? '')
            ->setAvatarToken($data['avatar']['token'] ?? '')
            ->setAvatarUrl($data['avatar']['url'] ?? '')
            ->setAvatarState($data['avatar']['state'] ?? '')
            ->setTitle($data['title'] ?? '')
            ->setBio($data['bio'] ?? '')
            ->setPronunciation($data['pronunciation'] ?? '')
            ->setPronouns($data['pronouns'] ?? '')
            ->setEvent($data['event'] ?? '')
            ->setOverrideSisStickiness($data['override_sis_stickiness'] ?? true);
    }

    /**
     * Converts the user object to an associative array with customizable key formatting.
     *
     * @param string $keyStyle Output format: 'UPPER_SNAKE_CASE', 'lower_snake_case', 'camelCase', 'CamelCase'.
     * @return array
     */
    public function toArray(string $keyStyle = 'camelCase'): array
    {
        $data = [
            'name' => $this->name,
            'shortName' => $this->shortName,
            'sortableName' => $this->sortableName,
            'timeZone' => $this->timeZone,
            'email' => $this->email,
            'locale' => $this->locale,
            'avatarToken' => $this->avatarToken,
            'avatarUrl' => $this->avatarUrl,
            'avatarState' => $this->avatarState,
            'title' => $this->title,
            'bio' => $this->bio,
            'pronunciation' => $this->pronunciation,
            'pronouns' => $this->pronouns,
            'event' => $this->event,
            'overrideSisStickiness' => $this->overrideSisStickiness,
        ];

        return $this->convertArrayKeys($data, $keyStyle);
    }


}
