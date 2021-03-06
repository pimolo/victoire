<?php

namespace Victoire\Bundle\MediaBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Victoire\Bundle\MediaBundle\Entity\Folder;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures that make a general media-folder for a project
 * and for every type of media a folder in that media-folder
 */
class FolderFixtures extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $gal = new Folder($manager);
        $gal->setName('Media');
        $gal->setTranslatableLocale('en');
        $gal->setRel("media");
        $manager->persist($gal);
        $manager->flush();
        $this->addReference('media-folder-en', $gal);

        $gal->setTranslatableLocale('nl');
        $manager->refresh($gal);
        $gal->setName("Media");
        $manager->persist($gal);
        $manager->flush();

        $gal->setTranslatableLocale('fr');
        $manager->refresh($gal);
        $gal->setName("Media");
        $manager->persist($gal);
        $manager->flush();

        $subgal = new Folder($manager);
        $subgal->setParent($gal);
        $subgal->setName('Images');
        $subgal->setTranslatableLocale('en');
        $subgal->setRel("image");
        $manager->persist($subgal);
        $manager->flush();
        $this->addReference('images-folder-en', $subgal);

        $subgal->setTranslatableLocale('nl');
        $manager->refresh($subgal);
        $subgal->setName('Afbeeldingen');
        $manager->persist($subgal);
        $manager->flush();

        $subgal->setTranslatableLocale('fr');
        $manager->refresh($subgal);
        $subgal->setName('Images');
        $manager->persist($subgal);
        $manager->flush();

        $subgal = new Folder($manager);
        $subgal->setParent($gal);
        $subgal->setName('Videos');
        $subgal->setTranslatableLocale('en');
        $subgal->setRel("video");
        $manager->persist($subgal);
        $manager->flush();
        $this->addReference('videos-folder-en', $subgal);

        $subgal->setTranslatableLocale('nl');
        $manager->refresh($subgal);
        $subgal->setName('Video\'s');
        $manager->persist($subgal);
        $manager->flush();

        $subgal->setTranslatableLocale('fr');
        $manager->refresh($subgal);
        $subgal->setName('Vidéos');
        $manager->persist($subgal);
        $manager->flush();

        $subgal = new Folder($manager);
        $subgal->setParent($gal);
        $subgal->setName('Slides');
        $subgal->setTranslatableLocale('en');
        $subgal->setRel("slideshow");
        $manager->persist($subgal);
        $manager->flush();
        $this->addReference('slides-folder-en', $subgal);

        $subgal->setTranslatableLocale('nl');
        $manager->refresh($subgal);
        $subgal->setName('Presentaties');
        $manager->persist($subgal);
        $manager->flush();

        $subgal->setTranslatableLocale('fr');
        $manager->refresh($subgal);
        $subgal->setName('Presentations');
        $manager->persist($subgal);
        $manager->flush();

        $subgal = new Folder($manager);
        $subgal->setParent($gal);
        $subgal->setName('Files');
        $subgal->setTranslatableLocale('en');
        $subgal->setRel("files");
        $manager->persist($subgal);
        $manager->flush();
        $this->addReference('files-folder-en', $subgal);

        $subgal->setTranslatableLocale('nl');
        $manager->refresh($subgal);
        $subgal->setName('Bestanden');
        $manager->persist($subgal);
        $manager->flush();

        $subgal->setTranslatableLocale('fr');
        $manager->refresh($subgal);
        $subgal->setName('Fichiers');
        $manager->persist($subgal);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }

}
