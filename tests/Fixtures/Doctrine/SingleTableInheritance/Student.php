<?php

namespace SignNow\Serializer\Tests\Fixtures\Doctrine\SingleTableInheritance;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Student extends Person
{
}
