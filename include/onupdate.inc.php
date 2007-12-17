<?php

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

function xoops_module_update_smartcontent($module) {

	include_once(XOOPS_ROOT_PATH . "/modules/" . $module->getVar('dirname') . "/include/functions.php");
	include_once(XOOPS_ROOT_PATH . "/modules/smartobject/class/smartdbupdater.php");


    $dbVersion  = smart_GetMeta('version', 'smartcontent');
    if (!$dbVersion) {
    	$dbVersion = 0;
    }

	$dbupdater = new SmartobjectDbupdater();

    ob_start();

	echo "<code>" . _SDU_UPDATE_UPDATING_DATABASE . "<br />";

    // db migrate version = 1
    $newDbVersion = 1;
	if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

		smartcontent_create_upload_folders();

		// Adding custom_css field in smartcontent_page
	    $table = new SmartDbTable('smartcontent_page');
	    if (!$table->fieldExists('custom_css')) {
	    	$table->addNewField('custom_css', "TEXT NOT NULL default ''");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
		unset($table);

		// Adding custom_css field in smartcontent_category
	    $table = new SmartDbTable('smartcontent_category');
	    if (!$table->fieldExists('custom_css')) {
	    	$table->addNewField('custom_css', "TEXT NOT NULL default ''");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
		unset($table);

	    $table = new SmartDbTable('smartcontent_page');
	    if (!$table->fieldExists('custom_css')) {
			$table->addNewField('custom_css', "TEXT NOT NULL default ''");
	    }

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	    }
	}

    // db migrate version = 2
    $newDbVersion = 2;
    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartcontent_page');
    	$table->addNewField('external_link', "TEXT NOT NULL default ''");

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	  }
    }

    // db migrate version = 3
    $newDbVersion = 3;
    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartcontent_page');
    	$table->addNewField('submenu', "tinyint(1) NOT NULL default '1'");

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	  }
    }

    // db migrate version = 4
    $newDbVersion = 4;
    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartcontent_page');
    	$table->addNewField('link2page', "INT(11) default 0");

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	  }
    }

	    // db migrate version = 4
    $newDbVersion = 5;
    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartcontent_page');
    	$table->addNewField('menu_title', "VARCHAR(255) default ''");
    	$table->addDropedField('link2page');
		$table->addUpdatedField('parentid', 0);
		if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	  }

	  $table = new SmartDbTable('smartcontent_category');
    	$table->dropTable();

	    if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	  }
    }

  	// db migrate version = 5
    $newDbVersion = 6;
    if ($dbVersion < $newDbVersion) {
    	echo "Database migrate to version " . $newDbVersion . "<br />";

	    $table = new SmartDbTable('smartcontent_page');
    	$table->addNewField('is_external_link', "INT(1) default 0");
		if (!$dbupdater->updateTable($table)) {
	        /**
	         * @todo trap the errors
	         */
	  	}
	}

	echo "</code>";

    $feedback = ob_get_clean();
    if (method_exists($module, "setMessage")) {
        $module->setMessage($feedback);
    }
    else {
        echo $feedback;
    }
    smart_SetMeta("version", $newDbVersion, "smartcontent"); //Set meta version to current
    return true;
}

function xoops_module_install_smartcontent($module) {

    ob_start();

	include_once(XOOPS_ROOT_PATH . "/modules/" . $module->getVar('dirname') . "/include/functions.php");

	smartcontent_create_upload_folders();

    $feedback = ob_get_clean();
    if (method_exists($module, "setMessage")) {
        $module->setMessage($feedback);
    }
    else {
        echo $feedback;
    }

	return true;
}


?>