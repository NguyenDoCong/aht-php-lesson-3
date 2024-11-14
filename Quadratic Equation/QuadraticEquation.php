<?php
class QuadraticEquation
{
    private $a;
    private $b;
    private $c;

    public function __construct($a, $b, $c)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
    }
    public function getA()
    {
        return $this->a;
    }

    public function getB()
    {
        return $this->b;
    }

    public function getC()
    {
        return $this->c;
    }

    public function getDiscriminant()
    {
        return $this->b * $this->b - 4 * $this->a * $this->c;
    }

    public function getRoot1()
    {
        return (-$this->b + pow($this->getDiscriminant(), 0.5)) / 2 / $this->a;
    }

    public function getRoot2()
    {
        return (-$this->b - pow($this->getDiscriminant(), 0.5)) / 2 / $this->a;
    }
}

$a = readline("Enter a: ");
$b = readline("Enter b: ");
$c = readline("Enter c: ");

$solve = new QuadraticEquation($a, $b, $c);
if ($solve->getDiscriminant() > 0):
    echo "The equation has 2 roots " . $solve->getRoot1() . " and " . $solve->getRoot2();
elseif ($solve->getDiscriminant() == 0):
    echo "The equation has 1 root " . $solve->getRoot1();
else:
    echo "The equation has no roots";
endif;
