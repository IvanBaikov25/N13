<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'order')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private Customer $customer;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    private string $total;

    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'orders')]
    #[ORM\JoinTable(name: 'order_book')]
    private Collection $books;

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->total = '0.00';
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getCustomer(): Customer
    {
        return $this->customer;
    }
    public function setCustomer(Customer $customer): self
    {
        $this->customer = $customer;
        return $this;
    }
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    public function getTotal(): string
    {
        return $this->total;
    }
    public function setTotal(string $total): self
    {
        $this->total = $total;
        return $this;
    }
    public function getBooks(): Collection
    {
        return $this->books;
    }
    public function addBook(Book $book): self
    {
        if (!$this->books->contains($book)) {
            $this->books[] = $book;
        }
        return $this;
    }
    public function removeBook(Book $book): self
    {
        $this->books->removeElement($book);
        return $this;
    }
}