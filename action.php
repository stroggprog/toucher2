<?php
/**
 * DokuWiki Plugin dlcounter (Action Component)
 *
 * records and displays download counts for files with specified extensions in the media library
 *
 * @author Phil Ide <phil@pbih.eu>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

// must be run within Dokuwiki
if (!defined('DOKU_INC')) {
    die();
}

class action_plugin_toucher2 extends DokuWiki_Action_Plugin
{

    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     *
     * @return void
     */
    public function register(Doku_Event_Handler $controller)
    {
        $controller->register_hook('COMMON_WIKIPAGE_SAVE', 'AFTER', $this, 'handle_wikipage_save');

    }

    /**
     * [Custom event handler which performs action]
     *
     * Called for event:
     *
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     *
     * @return void
     */
    public function handle_wikipage_save(Doku_Event $event, $param)
    {
        global $INFO;
        $act = false;

        // only do this if enabled for page saves
        if( $this->getConf('on_demand') ){
            // manager and plugin isn't enabled for admins only
            if( $INFO['ismanager'] && !$this->getConf('admin_only') ){
                $act = true;
            }
            else if( $INFO['isadmin'] ){
                $act = true;
            }

            if( $act ){
                touch(DOKU_CONF."local.php");
            }
        }
    }

}

