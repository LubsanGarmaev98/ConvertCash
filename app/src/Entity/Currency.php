<?php
namespace App\Entity;

use App\Repository\CurrencyRepository;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: CurrencyRepository::class), Table(name: 'currencies')]
class Currency{

    #[Id, Column(name: 'currency_id', type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    protected int $currencyId;
    #[Column(name: 'num_code', type: 'integer')]
    protected int $numCode;
    #[Column(name: 'char_code', type: 'string')]
    protected string $charCode;
    #[Column(name: 'nominal', type: 'integer')]
    protected int $nominal;

    #[Column(name: 'name', type: 'string')]
    protected string $name;

    #[Column(name: 'value', type: 'float')]
    protected float $value;

    #[Column(name: 'previous', type: 'float')]
    protected float $previous;
    #[Column(name: 'date_time', type: 'datetime')]
    protected DateTime $dateTime;

    public function __construct(
        int $numCode,
        string $charCode,
        int $nominal,
        string $name,
        float $value,
        float $previous,
        DateTime $dateTime
    )
    {
        $this->numCode   = $numCode;
        $this->charCode  = $charCode;
        $this->nominal   = $nominal;
        $this->name      = $name;
        $this->value     = $value;
        $this->previous  = $previous;
        $this->dateTime  = $dateTime;
    }

    /**
     * @return int
     */
    public function getNumCode(): int
    {
        return $this->numCode;
    }

    /**
     * @param int $numCode
     */
    public function setNumCode(int $numCode): void
    {
        $this->numCode = $numCode;
    }

    /**
     * @return string
     */
    public function getCharCode(): string
    {
        return $this->charCode;
    }

    /**
     * @param string $charCode
     */
    public function setCharCode(string $charCode): void
    {
        $this->charCode = $charCode;
    }

    /**
     * @return int
     */
    public function getNominal(): int
    {
        return $this->nominal;
    }

    /**
     * @param int $nominal
     */
    public function setNominal(int $nominal): void
    {
        $this->nominal = $nominal;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getPrevious(): float
    {
        return $this->previous;
    }

    /**
     * @param float $previous
     */
    public function setPrevious(float $previous): void
    {
        $this->previous = $previous;
    }

    /**
     * @return int
     */
    public function getCurrencyId(): int
    {
        return $this->currencyId;
    }

    /**
     * @param int $currencyId
     */
    public function setCurrencyId(int $currencyId): void
    {
        $this->currencyId = $currencyId;
    }

    public function getCharCodeValue(): array
    {
        return [
            "charCode" => $this->getCharCode(),
            "value" =>  $this->getValue()
        ];
    }

    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return $this->dateTime;
    }

    /**
     * @param DateTime $dateTime
     */
    public function setDateTime(DateTime $dateTime): void
    {
        $this->dateTime = $dateTime;
    }
}