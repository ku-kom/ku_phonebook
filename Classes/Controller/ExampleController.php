<?php

declare(strict_types=1);

/*
 * This file is part of the package ku_prototype.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace UniversityOfCopenhagen\KuPrototype\ViewHelpers;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Http\Response;

class ExampleController
{
   /** @var ResponseFactoryInterface */
   private $responseFactory;

   public function __construct(ResponseFactoryInterface $responseFactory)
   {
      $this->responseFactory = $responseFactory;
   }
  
    public function doSomethingAction(ServerRequestInterface $request): Response
    {       
       $query = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('q');
       return $query;    
    }
}