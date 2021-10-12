<?php
/*
 * CKFinder
 * ========
 * http://ckfinder.com
 * Copyright (C) 2007-2011, CKSource - Frederico Knabben. All rights reserved.
 *
 * The software, this file and its contents are subject to the CKFinder
 * License. Please read the license.txt file before using, installing, copying,
 * modifying or distribute this file or part of its contents. The contents of
 * this file is part of the Source Code of CKFinder.
 */
if (!defined('IN_CKFINDER')) exit;

/**
 * @package CKFinder
 * @subpackage CommandHandlers
 * @copyright CKSource - Frederico Knabben
 */

/**
 * Include base XML command handler
 */
require_once CKFINDER_CONNECTOR_LIB_DIR . "/CommandHandler/XmlCommandHandlerBase.php";

/**
 * Handle CopyFiles command
 *
 * @package CKFinder
 * @subpackage CommandHandlers
 * @copyright CKSource - Frederico Knabben
 */
class CKFinder_Connector_CommandHandler_CopyFiles extends CKFinder_Connector_CommandHandler_XmlCommandHandlerBase
{
    /**
     * Command name
     *
     * @access private
     * @var string
     */
    var $command = "CopyFiles";


    /**
     * handle request and build XML
     * @access protected
     *
     */
    function buildXml()
    {
        if (empty($_POST['CKFinderCommand']) || $_POST['CKFinderCommand'] != 'true') {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
        }

        $clientPath = $this->_currentFolder->getClientPath();
        $sServerDir = $this->_currentFolder->getServerPath();
        $currentResourceTypeConfig = $this->_currentFolder->getResourceTypeConfig();
        $_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
        $_aclConfig = $_config->getAccessControlConfig();
        $aclMasks = array();
        $_resourceTypeConfig = array();

        if (!$this->_currentFolder->checkAcl(CKFINDER_CONNECTOR_ACL_FILE_RENAME | CKFINDER_CONNECTOR_ACL_FILE_UPLOAD | CKFINDER_CONNECTOR_ACL_FILE_DELETE)) {
            $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_UNAUTHORIZED);
        }

        // Create the "Errors" node.
        $oErrorsNode = new CKFinder_Connector_Utils_XmlNode("Errors");
        $errorCode = CKFINDER_CONNECTOR_ERROR_NONE;
        $copied = 0;
        $copiedAll = 0;
        if (!empty($_POST['copied'])) {
            $copiedAll = intval($_POST['copied']);
        }
        $checkedPaths = array();

        $oCopyFilesNode = new Ckfinder_Connector_Utils_XmlNode("CopyFiles");

        if (!empty($_POST['files']) && is_array($_POST['files'])) {
            foreach ($_POST['files'] as $index => $arr) {
                if (empty($arr['name'])) {
                    continue;
                }
                if (!isset($arr['name'], $arr['type'], $arr['folder'])) {
                    $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
                }

                // file name
                $name = CKFinder_Connector_Utils_FileSystem::convertToFilesystemEncoding($arr['name']);
                // resource type
                $type = $arr['type'];
                // client path
                $path = CKFinder_Connector_Utils_FileSystem::convertToFilesystemEncoding($arr['folder']);
                // options
                $options = (!empty($arr['options'])) ? $arr['options'] : '';

                $destinationFilePath = $sServerDir.$name;

                // check #1 (path)
                if (!CKFinder_Connector_Utils_FileSystem::checkFileName($name) || preg_match(CKFINDER_REGEX_INVALID_PATH, $path)) {
                    $this->_errorHandler->throwError(CKFINDER_CONNECTOR_ERROR_INVALID_REQUEST);
                }

                // get resource type config for current file
                if (!isset($_resourceTypeConfig[$type])) {
                    $_resourceTypeConfig[$type] = $_config->getResourceTypeConfig($type);
                }

                // check #2 (resource type)
             