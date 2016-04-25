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
new \Twig_SimpleFilter('since', array($this, 'sinceFilter')),
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
public function sinceFilter($nbSeconds)
{
$sentences = array (
'{1} techcorp.elapsed.one.second',
']1,60[ techcorp.elapsed.many.second',
'[60,120[ techcorp.elapsed.one.minute',
'[120,3600[ techcorp.elapsed.many.minute',
'[3600,7200[ techcorp.elapsed.one.hour',
'[7200,86400[ techcorp.elapsed.many.hour',
'[86400,172800[ techcorp.elapsed.one.day',
'[172800,Inf[ techcorp.elapsed.many.day',
);
$matchingTranslation = $this->translator->transChoice (implode('| ', $sentences), $nbSeconds);

$nbMinutes = floor($nbSeconds / 60);
$nbHours = floor($nbSeconds / 3600);
$nbDays = floor($nbSeconds / 86400);
$parameters = array (
'%nbSeconds%' => $nbSeconds,
'%nbMinutes%' => $nbMinutes,
'%nbHours%' => $nbHours,
'%nbDays%' => $nbDays,
);

return $this->translator->trans($matchingTranslation, $parameters);
}

}