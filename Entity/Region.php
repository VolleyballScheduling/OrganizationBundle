<?php
namespace Volleyball\Bundle\OrganizationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Volleyball\Bundle\UtilityBundle\Traits\SluggableTrait;
use Volleyball\Bundle\UtilityBundle\Traits\TimestampableTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="region")
 */
class Region
{
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
     * @ORM\ManyToOne(targetEntity="Council", inversedBy="regions")
     * @ORM\JoinColumn(name="council_id", referencedColumnName="id")
     */
    protected $council;
    
    /**
     * @{inheritdoc}
     * @ORM\ManyToOne(targetEntity="Organization", inversedBy="regions")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id")
     */
    protected $organization;
    
    /**
     * @ORM\OneToMany(targetEntity="Volleyball\Bundle\CourseBundle\Entity\Course", mappedBy="region")
     */
    protected $courses;
    
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
    public function getCouncil()
    {
        return $this->council;
    }
    
    /**
     * @{inheritdoc}
     */
    public function setCouncil(\Volleyball\Bundle\OrganizationBundle\Entity\Council $council)
    {
        $this->council = $council;
        
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
}
