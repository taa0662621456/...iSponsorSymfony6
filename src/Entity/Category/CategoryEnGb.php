<?php

namespace App\Entity\Category;

use App\Entity\BaseTrait;
use App\Entity\CategoryLanguageTrait;
use App\Entity\ObjectTrait;
use App\Repository\Category\CategoryRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


#[ORM\Table(name: 'category_en_gb')]
#[ORM\Index(columns: ['slug'], name: 'category_en_gb_idx')]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CategoryEnGb
{
    use CategoryLanguageTrait;
    use ObjectTrait;
    use BaseTrait;

    public function __construct()
    {
        $t = new DateTime();
        $this->slug = (string)Uuid::v4();

        $this->lastRequestDate = $t->format('Y-m-d H:i:s');
        $this->createdAt = $t->format('Y-m-d H:i:s');
        $this->modifiedAt = $t->format('Y-m-d H:i:s');
        $this->lockedAt = $t->format('Y-m-d H:i:s');
        $this->published = true;
    }
}
