<?php
namespace Volleyball\Bundle\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

use \Volleyball\Bundle\UtilityBundle\Traits\SluggableTrait;
use \Volleyball\Bundle\UtilityBundle\Traits\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass="\Volleyball\Bundle\OrganizationBundle\Repository\OrganizationRepository")
 * @ORM\Table(name="organization")
 */
class Organization extends \Volleyball\Component\Organization\Model\Organization
{
    use SluggableTrait;
    use TimestampableTrait;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @{inheritdoc}
     * @ORM\Column(type="string")
     * @Assert\Length(
     *      min = "1",
     *      max = "250",
     *      minMessage = "Name must be at least {{ limit }} characters length",
     *      maxMessage = "Name cannot be longer than {{ limit }} characters length"
     * )
     */
    protected $name;
    
    /**
     * @{inheritdoc}
     * @ORM\Column(type="text")
     */
    protected $description;
    
    /**
     * @{inheritdoc}
     * @ORM\OneToMany(targetEntity="Volleyball\Bundle\PasselBundle\Entity\Type", mappedBy="organization")
     */
    protected $types;
    
    /**
     * @{inheritdoc}
     * @ORM\OneToMany(targetEntity="Council", mappedBy="organization")
     */
    protected $councils;
    
    /**
     * @{inheritdoc}
     * @ORM\OneToMany(targetEntity="Region", mappedBy="organization")
     */
    protected $regions;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @{inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @{inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @{inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @{inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @{inheritdoc}
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @{inheritdoc}
     */
    public function setTypes(array $types)
    {
        if (! $types instanceof ArrayCollection) {
            $types = new ArrayCollection($types);
        }

        $this->types = $types;

        return $this;
    }

    /**
     * Has types
     *
     * @return boolean
     */
    public function hasTypes()
    {
        return !$this->types->isEmpty();
    }

    /**
     * @{inheritdoc}
     */
    public function getType($type)
    {
        return $this->types->get($type);
    }

    /**
     * @{inheritdoc}
     */
    public function addType(\Volleyball\Bundle\PasselBundle\Entity\Type $type)
    {
        $this->types->add($type);

        return $this;
    }

    /**
     * @{inheritdoc}
     */
    public function removeType($type)
    {
        $this->types->remove($type);

        return $this;
    }

    /**
     * @{inheritdoc}
     */
    public function getCouncils()
    {
        return $this->councils;
    }

    /**
     * @{inheritdoc}
     */
    public function setCouncils(array $councils)
    {
        if (! $councils instanceof ArrayCollection) {
            $councils = new ArrayCollection($councils);
        }

        $this->councils = $councils;

        return $this;
    }

    /**
     * Has councils
     *
     * @return boolean
     */
    public function hasCouncils()
    {
        return !$this->councils->isEmpty();
    }

    /**
     * @{inheritdoc}
     */
    public function getCouncil($council)
    {
        return $this->councils->get($council);
    }

    /**
     * @{inheritdoc}
     */
    public function addCouncil(Council $council)
    {
        $this->councils->add($council);

        return $this;
    }

    /**
     * @{inheritdoc}
     */
    public function removeCouncil($council)
    {
        $this->councils->remove($council);

        return $this;
    }

    /**
     * @{inheritdoc}
     */
    public function getRegions()
    {
        return $this->regions;
    }

    /**
     * @{inheritdoc}
     */
    public function setRegions(array $regions)
    {
        if (! $regions instanceof ArrayCollection) {
            $regions = new ArrayCollection($regions);
        }

        $this->regions = $regions;

        return $this;
    }

    /**
     * Has regions
     *
     * @return boolean
     */
    public function hasRegions()
    {
        return !$this->regions->isEmpty();
    }

    /**
     * @{inheritdoc}
     */
    public function getRegion($region)
    {
        return $this->regions->get($region);
    }

    /**
     * @{inheritdoc}
     */
    public function addRegion(Region $region)
    {
        $this->regions->add($region);

        return $this;
    }

    /**
     * @{inheritdoc}
     */
    public function removeRegion($region)
    {
        $this->regions->remove($region);

        return $this;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
        $this->councils = new \Doctrine\Common\Collections\ArrayCollection();
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
