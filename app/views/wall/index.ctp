<?php
/**
 * Tatoeba Project, free collaborative creation of multilingual corpuses project
 * Copyright (C) 2009 Allan SIMON <allan.simon@supinfo.com>
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
 *
 * PHP version 5
 *
 * @category PHP
 * @package  Tatoeba
 * @author   HO Ngoc Phuong Trang <tranglich@gmail.com>
 * @license  Affero General Public License
 * @link     http://tatoeba.org
 */

/**
 * General view for the wall. Here are displayed all the messages.
 *
 * @category Wall
 * @package  Views
 * @author   HO Ngoc Phuong Trang <tranglich@gmail.com>
 * @license  Affero General Public License
 * @link     http://tatoeba.org
 */ 

$this->pageTitle = 'Tatoeba - ' . __('Wall', true);

?>
<div id="annexe_content" >
    <div class="module" >
        <h2><?php __('Tips'); ?></h2>
        <p>
            <?php
            __(
                'Here you can ask general questions like how to use Tatoeba, ' .
                'report bugs or strange behaviors, or simply socialize with the'.
                ' rest of the community.'
            );
            ?>
         </p>

        <p><?php __("Have fun! Don't be shy!"); ?></p>
    </div>

    <div class="module" >
        <h2><?php __('Latest messages'); ?></h2>
        <ul>
            <?php
            $mesg = count($tenLastMessages);
            
            for ($i = 0 ; $i < min(10, $mesg); $i++) {
                $currentMessage = $tenLastMessages[$i] ;
                echo '<li>';
                // text of the link
                $text = $date->ago($currentMessage['Wall']['date'])
                        . ", "
                        . __('by ', true)
                        . $currentMessage['User']['username'];
                $path = array(
                    'controller' => 'wall',
                    'action' => 'index#message_'.$currentMessage['Wall']['id']
                    );
                // link
                echo $html->link($text, $path);
                echo '</li>';
            };
            ?>
        </ul>
    </div>
</div>

<div id="main_content">
    <div class="module">
        <h2>
            <?php
            // TODO extract this 
            echo $paginator->counter(
                array(
                    'format' => __(
                        'Wall (%count% threads)',
                        true
                    )
                )
            );
            ?>
        </h2>
        
        <?php
        // leave a comment part
        if ($isAuthenticated) {
            echo '<div id="sendMessageForm">'."\n";
            echo $wall->displayAddMessageToWallForm();
            echo '</div>'."\n";
        }
        ?>
        
        <?php
        // Pagination
        // TODO extract this
        ?>
        <div class="paging">
            <?php 
            echo $paginator->prev(
                '<< '.__('previous', true), 
                array(), 
                null, 
                array('class'=>'disabled')
            ); 
            
            echo $paginator->numbers(array('separator' => ''));
            
            echo $paginator->next(
                __('next', true).' >>',
                array(),
                null, 
                array('class'=>'disabled')
            ); 
            ?>
        </div>
        
        <ol class="wall">
        <?php
        // display comment part
        foreach ($allMessages as $message) {
        
            $messageId = $message['Wall']['id'];
            
            echo '<li id="message_'.$messageId.'" class="topThread" >'."\n";
            // Root message
            $wall->createRootDiv(
                $message['Wall'], 
                $message['User'], 
                $message['Permissions']
            );

            // replies
            echo '<div class="replies" id="messageBody_'.$messageId .'" >';
            if (!empty($message['children'])) {
                echo '<ul>';
                foreach ($message['children'] as $child ) {
                    $wall->createReplyDiv(
                        // this is because the allMessages array
                        // is indexed with message Id
                        $child['Wall'],
                        $child['User'],
                        $child['children'],
                        $child['Permissions']
                    );
                }
                echo '</ul>';
            }
            echo '</div>';
            echo '</li>';
        }
        ?>
        </ol>
        
        <?php
        // Pagination
        // TODO extract it
        ?>
        <div class="paging">
            <?php 
            echo $paginator->prev(
                '<< '.__('previous', true), 
                array(), 
                null, 
                array('class'=>'disabled')
            ); 
            
            echo $paginator->numbers(array('separator' => ''));
            
            echo $paginator->next(
                __('next', true).' >>',
                array(),
                null, 
                array('class'=>'disabled')
            ); 
            ?>
        </div>
    </div>
</div>
