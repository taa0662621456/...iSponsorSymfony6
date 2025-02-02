<?php

namespace App\DataFixtures;

use App\Entity\Category\Category;
use App\Entity\Project\Project;
use App\Entity\Project\ProductAttachment;
use App\Entity\Project\ProjectEnGb;
use App\Entity\Project\ProjectTag;
use App\Entity\Project\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use JetBrains\PhpStorm\NoReturn;

class ProjectFixtures extends Fixture implements DependentFixtureInterface
{
    public const PROJECT_COLLECTION = 'projectCollection';

    /**
     * @throws Exception
     */
    #[NoReturn]
    public function load(ObjectManager $manager)
	{
        $faker = Factory::create();
        $projectCollection = new ArrayCollection();
        $projectAttachmentCollection = new ArrayCollection();
        $projectTagCollection = new ArrayCollection();

        $categoryRepository = $manager->getRepository(Category::class)->findAll();
        $projectAttachmentRepository = $manager->getRepository(ProductAttachment::class)->findAll();
        $projectTypeRepository = $manager->getRepository(Type::class)->findAll();
        $projectTagRepository = $manager->getRepository(ProjectTag::class)->findAll();
        $projectRepository = $manager->getRepository(ProjectTag::class)->findAll();

        for ($p = 1; $p <= 10; $p++) {

            $project = new Project();
            $projectType = new Type();
            $projectEnGb = new ProjectEnGb();
            $projectAttachment = new ProductAttachment();

            if (0 != count($projectRepository)){

                foreach ($projectRepository as $item){
                    if (!$projectCollection->contains($item)){
                        $projectCollection->add($item);
                        $project = $projectCollection[array_rand($projectRepository)];
                    }
                }

            }

            $tag = $projectTagRepository[array_rand($projectTagRepository)];

            if (!$projectTagCollection->contains($tag)){
                $projectTagCollection->add($tag);
            }
            $tag = $projectTagCollection->current();

            $attachment = $projectAttachmentRepository[array_rand($projectAttachmentRepository)];

            if (!$projectAttachmentCollection->contains($attachment)){
                $projectAttachmentCollection->add($attachment);
            }

            $attachment = $projectAttachmentCollection->current();

            #
//            $this->getReference(ProjectTypeFixtures::PROJECT_TYPE);
            $projectType->setFirstTitle('ProjectTypeFT #_' . $p);
            $projectType->setMiddleTitle('ProjectTypeMT #_' . $p);
            $projectType->setLastTitle('ProjectTypeLT #_' . $p);
            #
            //$project->setProjectCategory($categoryRepository[array_rand($categoryRepository)]);
            //$project->addProjectAttachment($attachment);
            //$project->addProjectTag($tag);

            //$project->setProjectEnGb($projectEnGb);
            //$project->setProjectType($projectTypeRepository[array_rand($projectTypeRepository)]);
            #
            $projectEnGb->setProjectTitle('Project #_' . $p);
            $projectEnGb->setFirstTitle('ProjectFT #_' . $p);
            $projectEnGb->setMiddleTitle('ProjectMT #_' . $p);
            $projectEnGb->setLastTitle('ProjectLT #_' . $p);
            #
//            $this->getReference(ProjectAttachmentFixtures::PROJECT_ATTACHMENT_COLLECTION);

            $projectAttachment->setFirstTitle('some file');

            #
            $manager->persist($projectAttachment);
            $manager->persist($projectType);
            $manager->persist($projectEnGb);
            $manager->persist($project);

            $manager->flush();

		}

        $this->addReference(self::PROJECT_COLLECTION, $projectCollection);
	}

	public function getDependencies (): array
    {
		return [
            VendorFixtures::class,
            AttachmentFixtures::class,
            ReviewProjectFixtures::class,
            ReviewProductFixtures::class,
            CategoryAttachmentFixtures::class,
            ProjectTypeFixtures::class,
            ProjectAttachmentFixtures::class,
            ProjectTagFixtures::class,
            OrderStatusFixtures::class,
        ];
	}

	public function getOrder(): int
    {
		return 10;
	}

	/**
	 * @return string[]
	 */
	public static function getGroups(): array
	{
		return ['project'];
	}
}
