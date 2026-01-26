<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DbUpdate extends CI_Controller {

    public function index() {
        $this->load->database();
        $this->load->dbforge();

        // Table _rappel_anatomique
        if (!$this->db->table_exists('_rappel_anatomique')) {
            $fields = array(
                'IDRappel' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'IDChapitre' => array(
                    'type' => 'INT',
                    'constraint' => 11
                ),
                'Contenu' => array(
                    'type' => 'TEXT',
                    'null' => TRUE
                ),
                'Fichier' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => TRUE
                )
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('IDRappel', TRUE);
            $this->dbforge->create_table('_rappel_anatomique');
            echo "Table _rappel_anatomique created.<br>";
        } else {
            echo "Table _rappel_anatomique already exists.<br>";
        }

        // Table _rappel_images
        if (!$this->db->table_exists('_rappel_images')) {
            $fields = array(
                'IDImage' => array(
                    'type' => 'INT',
                    'constraint' => 11,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'IDRappel' => array(
                    'type' => 'INT',
                    'constraint' => 11
                ),
                'FichierImage' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 255
                )
            );
            $this->dbforge->add_field($fields);
            $this->dbforge->add_key('IDImage', TRUE);
            $this->dbforge->create_table('_rappel_images');
            echo "Table _rappel_images created.<br>";
        } else {
            echo "Table _rappel_images already exists.<br>";
        }
    }
}
