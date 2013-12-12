<?php

/**
 * Give a warm greeting to our friendly user
 *
 * PHP version 5
 *
 * @category Sample
 * @package  StatusNet
 * @author   Evan Prodromou <evan@status.net>
 * @license  http://www.fsf.org/licensing/licenses/agpl.html AGPLv3
 * @link     http://status.net/
 *
 * StatusNet - the distributed open-source microblogging tool
 * Copyright (C) 2009, StatusNet, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
if (!defined('STATUSNET')) {
    exit(1);
}

/**
 * Give a warm greeting to our friendly user
 *
 * This sample action shows some basic ways of doing output in an action
 * class.
 *
 * Action classes have several output methods that they override from
 * the parent class.
 *
 * @category Sample
 * @package  StatusNet
 * @author   Evan Prodromou <evan@status.net>
 * @license  http://www.fsf.org/licensing/licenses/agpl.html AGPLv3
 * @link     http://status.net/
 */
require_once INSTALLDIR . '/local/plugins/Grades/classes/Grades.php';
require_once INSTALLDIR . '/classes/User.php';
require_once INSTALLDIR . '/classes/Notice.php';

class NotesoptionsAction extends Action {

    var $user = null;

    /**
     * Take arguments for running
     *
     * This method is called first, and it lets the action class get
     * all its arguments and validate them. It's also the time
     * to fetch any relevant data from the database.
     *
     * Action classes should run parent::prepare($args) as the first
     * line of this method to make sure the default argument-processing
     * happens.
     *
     * @param array $args $_REQUEST args
     *
     * @return boolean success flag
     */
    function prepare($args) {
        parent::prepare($args);

        $this->user = common_current_user();


        return true;
    }

    /**
     * Class handler.
     *
     * @param array $args query arguments
     *
     * @return void
     */
    function handle($args) {

        parent::handle($args);
        if (!common_logged_in()) {
            $this->clientError(_('Not logged in.'));
            return;
        }
        $user = common_current_user();
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            common_redirect(common_local_url('all', array('nickname' => $user->nickname)));
            return;
        }
        $idGroup = $this->trimmed('idGroup');

        $token = $this->trimmed('token-' . $idGroup);
        if (!$token || $token != common_session_token()) {
            $this->clientError(_('There was a problem with your session token. Try again, please.'));
            return;
        }

        $this->showPage();
        


            }

function title() {
        return _m('Personalización de Apuntes');
    }
    
 function showContent() {
        if (empty($this->user)) {
            $this->element('p', array('class' => 'notespdf-options-error'), _m('Login first!'));
        } else {


            $idGroup = $this->trimmed('idGroup');
            
            $group = NotesPDF::getGroupByID($idGroup);
            
            $this->element('h2', null, 'Apuntes para el grupo ' . $group->getBestName());

            $this->elementStart('p');
            $this->raw('A continuación personalice los apuntes.');
            $this->elementEnd('p');
            
            $optionsForm = new Notesoptionsform($this, $group->id);
            $optionsForm->show();
            

        }
    }
    

    function isReadOnly($args) {

        return true;
    }
}
