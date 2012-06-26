<?php
/**
 * @package		Joomla
 * @subpackage	Content
 * @version		1.0.1
 * @license		TMYGS (Take Me, You Gypsy Stallion -Completely free and open)
 * \file nacc/nacccontent.php
 * \brief This is an inline content plugin for the NACC.
 * \license This code is completely open and free. You may access it by <a href="http://magshare.org/bmlt-the-basic-meeting-list-toolbox/">visiting the BMLT Project Site</a>. No one is allowed to resell this code. It should never be sold.
 * \version 1.0.0
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * \brief This is a plugin for the BMLT satellite that will allow the BMLT to display inline in text.
 *
 * @package		Joomla
 * @subpackage	Content
 * @since 		1.5
 */
class plgcontentNACCcontent extends JPlugin
{
	/**
	 * \brief Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @since 1.5
	 */
	function plgcontentNACCcontent( &$subject,	///< The object to observe
									$params			///< The object that holds the plugin parameters
									)
	{
		parent::__construct( $subject, $params );
	}
	
	/**
	 * \brief Prepare content method
	 *	This will replace any instance of <!--NACC--> with the NACC
	 *
	 * Method is called by the view
	 *
	 */
	function onPrepareContent(	&$article,	///< The article object.  Note $article->text is also available
								&$params,	///< The article params
								$limitstart	///< The 'page' number
							)
	{
        if ( preg_match ( '|\[\[\s?NACC\s?\]\]|', $article->text ) || preg_match ( '|\<!\-\-\s?NACC\s?\-\-\>|', $article->text ) )
            {
            $currenturl = JURI::root().'plugins/content';
            $document =& JFactory::getDocument();
            $document->addScript ( $currenturl.'/nacc/nacc.js' );
            $document->addStylesheet ( $currenturl.'/nacc/nacc.css', 'text/css' );
            $cc_text = '<div id="nacc_container"></div>'."\n";
            $cc_text .= '<noscript>';
            $cc_text .= '<h1 style="text-align:center">JavaScript Required</h1>';
            $cc_text .= '<h2 style="text-align:center">Sadly, you must enable JavaScript on your browser in order to use this cleantime calculator.</h2>';
            $cc_text .= '</noscript>';
            $cc_text .= '<script type="text/javascript">NACC_CleanTime("nacc_container", \''.JURI::root().'plugins/content/nacc\', true, true, false);</script>'."\n";
            $article->text = preg_replace('|\[\[\s?NACC\s?\]\]|', $cc_text, $article->text, 1 );
            $article->text = preg_replace('|\<!\-\-\s?NACC\s?\-\-\>|', $cc_text, $article->text, 1 );
            }
	}
}
