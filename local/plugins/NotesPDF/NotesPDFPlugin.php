<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once INSTALLDIR . '/local/plugins/NotesPDF/lib/fpdf/fpdf.php';

if (!defined('STATUSNET')) {
    exit(1);
}

class NotesPDFPlugin extends Plugin {

    function onInitializePlugin() {
        // A chance to initialize a plugin in a complete environment
    }

    function onCleanupPlugin() {
        // A chance to cleanup a plugin at the end of a program
    }

    function onAutoload($cls) {

        $dir = dirname(__FILE__);

        switch ($cls) {

            case 'NotespdfAction':
                include_once $dir . '/actions/' . $cls . '.php';
                return false;
            case 'NotesoptionsAction':
                include_once $dir . '/actions/' . $cls . '.php';
                return false;

            case 'Notesgenerateform':
            case 'Notesoptionsform':
                include_once $dir . '/lib/' . $cls . '.php';
                break;
            
            case 'NotesPDF':
            include_once $dir . '/classes/' . $cls.'.php';
            return false;
            break;

        default:
                return true;
        }
    }

    function onRouterInitialized($m) {
        $m->connect('main/notespdf', array('action' => 'notespdf'));
        $m->connect('main/notespdf/options', array('action' => 'notesoptions'));
        $m->connect('main/notespdf/generate', array('action' => 'notesgenerate'));
        return true;
    }

    function onStartDefaultLocalNav($action) {
        // '''common_local_url()''' gets the correct URL for the action name we provide
        $user = common_current_user();
        if (!empty($user)) {
            $action->out->elementStart('li');
            $action->out->element('h3', null, 'Tools');
            $action->out->elementStart('ul', array('class' => 'nav'));
            $action->menuItem(common_local_url('notespdf'), _m('Apuntes'), _m('Apuntes en PDF'), false, 'nav_notespdf');
            $action->out->elementEnd('ul');
            $action->out->elementEnd('li');
        }

        return true;
    }

    function onEndShowStyles($action) {
        $action->cssLink($this->path('css/notespdf.css'));
        return true;
    }

    function onPluginVersion(&$versions) {
        $versions[] = array('name' => 'NotesPDF',
            'version' => STATUSNET_VERSION,
            'author' => 'Alvaro Ortego Marcos',
            'rawdescription' =>
            _m('A plugin to export notes in PDF'));
        return true;
    }
    
      /*function onEndShowScripts($action)
      {
      $action->script($this->path('js/notespdf.js'));
      return true;
      }*/

}
