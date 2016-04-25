<?php
namespace TechCorp\FrontBundle\Component\Twig;
class ElapsedTwigFilterExtension extends \Twig_Extension
{
private $translator;
public function __construct ($translator){
$this->translator = $translator;
}
public function getFilters()
{
return array(
new \Twig_SimpleFilter('elapsed', array($this, 'elapsedFilter')),
);
}
public function elapsedFilter(\DateTime $dateTime)
{
$delta = time() - $dateTime->getTimestamp();
if ($delta<0)
throw new \InvalidArgumentException("elapsed can't handle dates in the
future.");
return $delta;
}
public function getName()
{
return 'elapsed_extension';
}
}