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

class ExampleController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

   /**
   * AJAX Call
   * @param type $params
   * @param \TYPO3\CMS\Core\Http\AjaxRequestHandler $ajaxObj
   * 
   */
    public function listAction($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = NULL)
    {       
      $request =  \TYPO3\CMS\Core\Utility\GeneralUtility::_POST('searchstring');
      $request = htmlspecialchars(strip_tags($request));

      \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($request);

      $ajaxObj->addContent('success', $request);
      $ajaxObj->setContentFormat('json');

      return $this->ajaxObj->render();
    }
}