/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.baseHref = document.getElementsByTagName('base')[0].href.replace('admin/', '');
    config.height = '500px';
    config.contentsCss = CKEDITOR.basePath + 'contents-new.css';
    config.allowedContent = true;
};
