<?php
/**
 * @package		Joomla
 * @subpackage	Content
 * @version		1.1
 * @license		GPL v.3 Or Greater
 
 * \file nacc/nacccontent.php
 * \brief This is an inline content plugin for the NACC.
 * \version 1.1
 * \license GPL V.3 Or Greater
 
    NACC is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    NACC is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this code.  If not, see <http://www.gnu.org/licenses/>.
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
class plgContentNACCcontent extends JPlugin
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
	function plgContentNACCcontent( &$subject,	///< The object to observe
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
