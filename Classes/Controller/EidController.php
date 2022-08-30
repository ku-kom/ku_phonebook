<?php

declare(strict_types=1);

/*
 * This file is part of the package ku_phonebook.
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace UniversityOfCopenhagen\KuPhonebook;

use TYPO3\CMS\Core\Http\AjaxRequestHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EidController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

  
/**
* @param ResponseInterface $response
*/
public function phonebookResponse(ResponseInterface $response): ResponseInterface
{
$responseData = json_encode([
        'status' => 'OK',
        'data' => [
            'user'=> 'John Doe',
            'Message' => 'Hello world'
       ]
    ], JSON_UNESCAPED_UNICODE);

    $response->getBody()->write($this->createSuccessResponseObject($responseData));

    // Debug:
    \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($response);
    
    return $response
        ->withStatus(200)
        ->withHeader('Content-Type', 'application/json');
}
}