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
 *
 */

/**
 * @fileOverview Defines the {@link CKFinder.lang} object, for the Latin American Spanish
 *		language. This is the base file for all translations.
*/

/**
 * Constains the dictionary of language entries.
 * @namespace
 */
CKFinder.lang['es-mx'] =
{
	appTitle : 'CKFinder',

	// Common messages and labels.
	common :
	{
		// Put the voice-only part of the label in the span.
		unavailable		: '%1<span class="cke_accessibility">, no disponible</span>',
		confirmCancel	: 'Algunas opciones se han cambiado\r\n¿Está seguro de querer cerrar el diálogo?',
		ok				: 'Aceptar',
		cancel			: 'Cancelar',
		confirmationTitle	: 'Confirmación',
		messageTitle	: 'Información',
		inputTitle		: 'Pregunta',
		undo			: 'Deshacer',
		redo			: 'Rehacer',
		skip			: 'Omitir',
		skipAll			: 'Omitir todos',
		makeDecision	: '¿Qué acción debe realizarse?',
		rememberDecision: 'Recordar mi decisión'
	},


	dir : 'ltr',
	HelpLang : 'es-mx',
	LangCode : 'es-mx',

	// Date Format
	//		d    : Day
	//		dd   : Day (padding zero)
	//		m    : Month
	//		mm   : Month (padding zero)
	//		yy   : Year (two digits)
	//		yyyy : Year (four digits)
	//		h    : Hour (12 hour clock)
	//		hh   : Hour (12 hour clock, padding zero)
	//		H    : Hour (24 hour clock)
	//		HH   : Hour (24 hour clock, padding zero)
	//		M    : Minute
	//		MM   : Minute (padding zero)
	//		a    : Firt char of AM/PM
	//		aa   : AM/PM
	DateTime : 'dd/mm/yyyy H:MM',
	DateAmPm : ['AM', 'PM'],

	// Folders
	FoldersTitle	: 'Carpetas',
	FolderLoading	: 'Cargando...',
	FolderNew		: 'Por favor, escriba el nombre para la nueva carpeta: ',
	FolderRename	: 'Por favor, escriba el nuevo nombre para la carpeta: ',
	FolderDelete	: '¿Está seguro de que quiere borrar la carpeta "%1"?',
	FolderRenaming	: ' (Renombrando...)',
	FolderDeleting	: ' (Borrando...)',

	// Files
	FileRename		: 'Por favor, escriba el nuevo nombre del archivo: ',
	FileRenameExt	: '¿Está seguro de querer cambiar la extensión del archivo? El archivo puede dejar de ser usable',
	FileRenaming	: 'Renombrando...',
	FileDelete		: '¿Está seguro de que quiere borrar el archivo "%1"?',
	FilesLoading	: 'Cargando...',
	FilesEmpty		: 'Carpeta vacía',
	FilesMoved		: 'Archivo %1 movido a %2:%3',
	FilesCopied		: 'Archivo %1 copiado a %2:%3',

	// Basket
	BasketFolder		: 'Cesta',
	BasketClear			: 'Vaciar cesta',
	BasketRemove		: 'Quitar de la cesta',
	BasketOpenFolder	: 'Abrir carpeta padre',
	BasketTruncateConfirm : '¿Está seguro de querer quitar todos los archivos de la cesta?',
	BasketRemoveConfirm	: '¿Está seguro de querer quitar el archivo "%1" de la cesta?',
	BasketEmpty			: 'No hay archivos en la cesta, arrastra y suelta algunos.',
	BasketCopyFilesHere	: 'Copiar archivos de la cesta',
	BasketMoveFilesHere	: 'Mover archivos de la cesta',

	BasketPasteErrorOther	: 'Fichero %s error: %e',
	BasketPasteMoveSuccess	: 'Los siguientes ficheros han sido movidos: %s',
	BasketPasteCopySuccess	: 'Los siguientes ficheros han sido copiados: %s',

	// Toolbar Buttons (some used elsewhere)
	Upload		: 'Añadir',
	UploadTip	: 'Añadir nuevo archivo',
	Refresh		: 'Actualizar',
	Settings	: 'Configuración',
	Help		: 'Ayuda',
	HelpTip		: 'Ayuda',

	// Context Menus
	Select			: 'Seleccionar',
	SelectThumbnail : 'Seleccionar el icono',
	View			: 'Ver',
	Download		: 'Descargar',

	NewSubFolder	: 'Nueva Subcarpeta',
	Rename			: 'Renombrar',
	Delete			: 'Borrar',

	CopyDragDrop	: 'Copiar archivo aquí',
	MoveDragDrop	: 'Mover archivo aquí',

	// Dialogs
	Ren