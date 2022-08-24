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

class phonebookResults extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    public function listAction(){

    }

     /**
     * Collect data and prepare HTML output.
     *
     * @param array $params array of parameters, currently unused
     * @param AjaxRequestHandler $ajaxObj object of type AjaxRequestHandler
     * @return void
     */
    public function phonebookResultsction($params = array(), \TYPO3\CMS\Core\Http\AjaxRequestHandler &$ajaxObj = NULL) 
    {
        $request =  \TYPO3\CMS\Core\Utility\GeneralUtility::_POST('some_variable');
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($request);  
              
        // $limit = GeneralUtility::_GP('limit');
        // $page = GeneralUtility::_GP('page');
         
        $ajaxObj->addContent('success', $result);
        $ajaxObj->setContentFormat('json');

        return $this->ajaxObj->render();
    }
}
