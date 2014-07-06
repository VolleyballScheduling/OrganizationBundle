<?php
namespace Volleyball\Bundle\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

use \Volleyball\Bundle\UtilityBundle\Traits\SluggableTrait;
use \Volleyball\Bundle\UtilityBundle\Traits\TimestampableTrait;

/**
 * @ORM\Entity(repositoryClass="\Volleyball\Bundle\OrganizationBundle\Repository\CouncilRepository")
 * @ORM\Table(name="council")
 */
class Council extends \Volleyball\Component\Organization\Model\Council
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
     * @ORM\Column(type="string")
     * @Assert\Length(
     *      min = "1",
     *      max = "250",
     *      minMessage = "Name must be at least {{ limit }} characters length",
     *      maxMessage = "Name cannot be longer than {{ limit }} characters length"
     * )
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $description;
    
    /**
     * @{inheritdoc}
     * @ORM\ManyToOne(targetEntity="Organization", inversedBy="councils")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     */
    protected $organization;
    
    /**
     * @{inheritdoc}
     * @ORM\OneToMany(targetEntity="Region", mappedBy="council")
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
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @{inheritdoc}
     */
    public function setOrganization(\Volleyball\Bundle\OrganizationBundle\Entity\Organization $organization)
    {
        $this->organization = $organization;

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
    public function addRegion(\Volleyball\Bundle\OrganizationBundle\Entity\Region $region)
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
        $this->regions = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
