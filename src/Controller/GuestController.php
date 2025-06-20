<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Expression;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//#[IsGranted(new Expression('is_granted("ROLE_USER”) or is_granted("ROLE_ADMIN")'))]
#[IsGranted("ROLE_USER")]
class GuestController extends AbstractController
{

}
