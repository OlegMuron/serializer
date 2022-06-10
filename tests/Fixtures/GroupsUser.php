<?php

namespace Signnow\Serializer\Tests\Fixtures;

use Signnow\Serializer\Annotation\Groups;

class GroupsUser
{
    private $name;

    /**
     * @Groups({"nickname_group"})
     */
    private $nickname = 'nickname';

    /**
     * @Groups({"manager_group"})
     */
    private $manager;

    /**
     * @Groups({"friends_group"})
     */
    private $friends;

    public function __construct($name, GroupsUser $manager = null, array $friends = array())
    {
        $this->name = $name;
        $this->manager = $manager;
        $this->friends = $friends;
    }
}
